<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LetterManagementTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected User $kades;

    protected User $perangkat;

    protected User $rt;

    protected User $warga;

    protected Resident $residentWarga;

    protected LetterTemplate $sktmTemplate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();
        $this->kades = User::where('email', 'kades@sidesa.id')->firstOrFail();
        $this->perangkat = User::where('email', 'perangkat@sidesa.id')->firstOrFail();
        $this->rt = User::where('email', 'rt@sidesa.id')->firstOrFail();
        $this->warga = User::where('email', 'warga@sidesa.id')->firstOrFail();

        $this->residentWarga = Resident::where('nik', '3201011508900001')->firstOrFail();
        $this->sktmTemplate = LetterTemplate::where('code', 'SKTM')->firstOrFail();
    }

    /**
     * Test template surat dapat diakses oleh admin.
     */
    public function test_letter_templates_index_is_accessible(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/letter-templates');
        $response->assertStatus(200);
        $response->assertSee('SKTM');
        $response->assertSee('SKCK');
        $response->assertSee('DOMISILI');
    }

    /**
     * Test pratinjau (preview) HTML template surat dapat diakses.
     */
    public function test_letter_template_preview_is_accessible(): void
    {
        $response = $this->actingAs($this->superadmin)->get("/admin/letter-templates/{$this->sktmTemplate->id}/preview");
        $response->assertStatus(200);
        $response->assertSee('Pratinjau HTML: '.$this->sktmTemplate->name);
        $response->assertSee('PEMERINTAH KABUPATEN');
        $response->assertSee('Budi Santoso');
    }

    /**
     * Test warga dapat mengajukan permohonan surat baru.
     */
    public function test_citizen_can_submit_letter_request(): void
    {
        $response = $this->actingAs($this->warga)->post('/citizen/letters', [
            'letter_template_id' => $this->sktmTemplate->id,
            'purpose' => 'Persyaratan pengajuan beasiswa kuliah anak',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('letter_requests', [
            'user_id' => $this->warga->id,
            'resident_id' => $this->residentWarga->id,
            'letter_template_id' => $this->sktmTemplate->id,
            'status' => 'pending_rt',
            'purpose' => 'Persyaratan pengajuan beasiswa kuliah anak',
        ]);
    }

    /**
     * Test alur verifikasi 3 tahap: RT -> Staf Desa -> TTE Kades.
     */
    public function test_three_stage_approval_workflow(): void
    {
        // 1. Warga submit
        $this->actingAs($this->warga)->post('/citizen/letters', [
            'letter_template_id' => $this->sktmTemplate->id,
            'purpose' => 'Keperluan pendaftaran BPJS Kesehatan PBI',
        ]);

        $letter = LetterRequest::where('user_id', $this->warga->id)->latest('id')->firstOrFail();
        $this->assertEquals('pending_rt', $letter->status);

        // 2. Tahap 1: Verifikasi oleh RT
        $responseRt = $this->actingAs($this->rt)->post("/admin/letter-requests/{$letter->id}/verify-rt", [
            'notes' => 'Disetujui RT, pemohon adalah warga tetap RT 001',
        ]);
        $responseRt->assertRedirect();
        $letter->refresh();
        $this->assertEquals('pending_staff', $letter->status);
        $this->assertNotNull($letter->rt_verified_at);
        $this->assertEquals($this->rt->id, $letter->rt_verified_by);

        // 3. Tahap 2: Verifikasi oleh Staf Desa
        $responseStaff = $this->actingAs($this->perangkat)->post("/admin/letter-requests/{$letter->id}/verify-staff", [
            'notes' => 'Dokumen kependudukan dan KK cocok',
        ]);
        $responseStaff->assertRedirect();
        $letter->refresh();
        $this->assertEquals('pending_kades', $letter->status);
        $this->assertNotNull($letter->staff_verified_at);
        $this->assertEquals($this->perangkat->id, $letter->staff_verified_by);

        // 4. Tahap 3: Pengesahan & TTE Kepala Desa
        $responseKades = $this->actingAs($this->kades)->post("/admin/letter-requests/{$letter->id}/approve-kades", [
            'notes' => 'Disetujui dan ditandatangani secara elektronik',
        ]);
        $responseKades->assertRedirect();
        $letter->refresh();
        $this->assertEquals('approved', $letter->status);
        $this->assertNotNull($letter->kades_approved_at);
        $this->assertNotNull($letter->signed_at);
        $this->assertNotNull($letter->letter_number);
        $this->assertStringContainsString('470/', $letter->letter_number);
    }

    /**
     * Test permohonan surat dapat ditolak dengan alasan penolakan.
     */
    public function test_letter_request_can_be_rejected(): void
    {
        $this->actingAs($this->warga)->post('/citizen/letters', [
            'letter_template_id' => $this->sktmTemplate->id,
            'purpose' => 'Pengajuan bantuan modal usaha',
        ]);

        $letter = LetterRequest::where('user_id', $this->warga->id)->latest('id')->firstOrFail();

        $response = $this->actingAs($this->perangkat)->post("/admin/letter-requests/{$letter->id}/reject", [
            'rejection_reason' => 'Data penghasilan KK tidak memenuhi kriteria SKTM.',
        ]);

        $response->assertRedirect();
        $letter->refresh();
        $this->assertEquals('rejected', $letter->status);
        $this->assertEquals('Data penghasilan KK tidak memenuhi kriteria SKTM.', $letter->rejection_reason);
        $this->assertEquals($this->perangkat->id, $letter->rejected_by);
    }

    /**
     * Test download PDF surat resmi yang sudah disetujui.
     */
    public function test_can_download_approved_letter_pdf(): void
    {
        // Setup approved letter
        $letter = LetterRequest::create([
            'request_number' => 'REQ-TEST-0001',
            'letter_number' => '470/099/SKTM/Ds/2026',
            'letter_template_id' => $this->sktmTemplate->id,
            'resident_id' => $this->residentWarga->id,
            'user_id' => $this->warga->id,
            'purpose' => 'Uji Coba Generate PDF Surat',
            'status' => 'approved',
            'qr_token' => 'test-qr-token-12345678901234567890',
            'signed_at' => now(),
            'kades_approved_at' => now(),
            'kades_approved_by' => $this->kades->id,
        ]);

        $response = $this->actingAs($this->warga)->get("/citizen/letters/{$letter->id}/pdf");
        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
    }

    /**
     * Test halaman verifikasi scan QR code publik.
     */
    public function test_public_qr_verification_page(): void
    {
        $letter = LetterRequest::create([
            'request_number' => 'REQ-TEST-0002',
            'letter_number' => '470/100/SKTM/Ds/2026',
            'letter_template_id' => $this->sktmTemplate->id,
            'resident_id' => $this->residentWarga->id,
            'user_id' => $this->warga->id,
            'purpose' => 'Verifikasi Publik Keaslian Surat',
            'status' => 'approved',
            'qr_token' => 'verified-token-abcdef1234567890',
            'signed_at' => now(),
            'kades_approved_at' => now(),
            'kades_approved_by' => $this->kades->id,
        ]);

        // Akses tanpa login (publik)
        $response = $this->get("/verify/letter/{$letter->qr_token}");
        $response->assertStatus(200);
        $response->assertSee('DOKUMEN SAH');
        $response->assertSee('470/100/SKTM/Ds/2026');
        $response->assertSee($this->residentWarga->name);
    }

    /**
     * Test perangkat desa dapat mem-bypass verifikasi RT dengan berkas pengantar fisik.
     */
    public function test_staff_can_bypass_rt_verification(): void
    {
        $this->actingAs($this->warga)->post('/citizen/letters', [
            'letter_template_id' => $this->sktmTemplate->id,
            'purpose' => 'Warga datang langsung membawa pengantar fisik RT',
        ]);

        $letter = LetterRequest::where('user_id', $this->warga->id)->latest('id')->firstOrFail();
        $this->assertEquals('pending_rt', $letter->status);

        // Staf desa melakukan bypass RT
        $response = $this->actingAs($this->perangkat)->post("/admin/letter-requests/{$letter->id}/bypass-rt", [
            'bypass_notes' => 'Pengantar fisik No. 12/RT01/2026 telah diverifikasi di kantor desa',
        ]);

        $response->assertRedirect();
        $letter->refresh();

        // Status langsung meloncat ke pending_kades
        $this->assertEquals('pending_kades', $letter->status);
        $this->assertNotNull($letter->rt_verified_at);
        $this->assertNotNull($letter->staff_verified_at);
        $this->assertEquals($this->perangkat->id, $letter->rt_verified_by);
        $this->assertEquals($this->perangkat->id, $letter->staff_verified_by);
        $this->assertStringContainsString('Bypass Verifikasi RT', $letter->rt_notes);
    }

    /**
     * Test RT tidak dapat menolak surat jika sudah lolos tahap verifikasi RT.
     */
    public function test_rt_cannot_reject_letter_after_rt_verification(): void
    {
        $this->actingAs($this->warga)->post('/citizen/letters', [
            'letter_template_id' => $this->sktmTemplate->id,
            'purpose' => 'Surat keterangan untuk beasiswa',
        ]);

        $letter = LetterRequest::where('user_id', $this->warga->id)->latest('id')->firstOrFail();
        $this->assertEquals('pending_rt', $letter->status);

        // Pada tahap pending_rt, RT dapat melihat form verifikasi dan form penolakan
        $responseShowRt = $this->actingAs($this->rt)->get("/admin/letter-requests/{$letter->id}");
        $responseShowRt->assertStatus(200);
        $responseShowRt->assertSee('Verifikasi & Setujui Tahap RT/RW', false);
        $responseShowRt->assertSee('Tolak Permohonan Surat:');

        // RT melakukan verifikasi
        $this->actingAs($this->rt)->post("/admin/letter-requests/{$letter->id}/verify-rt", [
            'notes' => 'Disetujui RT 001',
        ]);

        $letter->refresh();
        $this->assertEquals('pending_staff', $letter->status);

        // Setelah diverifikasi, RT membuka halaman kembali:
        // Form penolakan dan form verifikasi HARUS hilang, berganti informasi status
        $responseShowAfterRt = $this->actingAs($this->rt)->get("/admin/letter-requests/{$letter->id}");
        $responseShowAfterRt->assertStatus(200);
        $responseShowAfterRt->assertDontSee('Tolak Permohonan Surat:');
        $responseShowAfterRt->assertSee('Anda telah memverifikasi permohonan ini pada tingkat RT/RW');

        // Jika RT mencoba mengirim request POST penolakan secara langsung, harus dicegah (403 Forbidden)
        $responseReject = $this->actingAs($this->rt)->post("/admin/letter-requests/{$letter->id}/reject", [
            'rejection_reason' => 'Mencoba menolak setelah tahap RT selesai',
        ]);
        $responseReject->assertStatus(403);

        // Berkas tetap pending_staff
        $letter->refresh();
        $this->assertEquals('pending_staff', $letter->status);

        // Namun staf desa berwenang untuk menolak pada tahap ini
        $responseStaffReject = $this->actingAs($this->perangkat)->post("/admin/letter-requests/{$letter->id}/reject", [
            'rejection_reason' => 'Persyaratan berkas KK belum diunggah',
        ]);
        $responseStaffReject->assertRedirect();
        $letter->refresh();
        $this->assertEquals('rejected', $letter->status);
    }

    /**
     * Test format nomor surat menggunakan template custom format dan manual override kades.
     */
    public function test_letter_number_supports_custom_template_format_and_manual_override(): void
    {
        // 1. Template dengan custom format nomor surat
        $skuTemplate = LetterTemplate::create([
            'code' => 'SKU-CUSTOM',
            'name' => 'Surat Keterangan Usaha Custom',
            'number_format' => '510/{nomor:4}/EKBANG/{bulan_romawi}/{tahun}',
            'content_template' => '<p>Surat keterangan usaha [NAMA].</p>',
            'is_active' => true,
        ]);

        $this->actingAs($this->warga)->post('/citizen/letters', [
            'letter_template_id' => $skuTemplate->id,
            'purpose' => 'Pengajuan pinjaman usaha',
        ]);

        $letter = LetterRequest::where('letter_template_id', $skuTemplate->id)->latest('id')->firstOrFail();

        // Bypass RT & verifikasi staf
        $this->actingAs($this->perangkat)->post("/admin/letter-requests/{$letter->id}/bypass-rt", [
            'bypass_notes' => 'Bypass verifikasi',
        ]);

        $letter->refresh();
        $this->assertEquals('pending_kades', $letter->status);

        // Kades menyetujui tanpa nomor manual -> menggunakan format template
        $this->actingAs($this->kades)->post("/admin/letter-requests/{$letter->id}/approve-kades", [
            'notes' => 'Disetujui',
        ]);

        $letter->refresh();
        $this->assertEquals('approved', $letter->status);
        $this->assertStringStartsWith('510/', $letter->letter_number);
        $this->assertStringContainsString('/EKBANG/', $letter->letter_number);

        // 2. Kades dapat meng-override nomor surat secara manual jika ada nomor buku register fisik
        $letter2 = LetterRequest::create([
            'request_number' => 'REQ-MANUAL-001',
            'letter_template_id' => $this->sktmTemplate->id,
            'resident_id' => $this->residentWarga->id,
            'user_id' => $this->warga->id,
            'purpose' => 'Keperluan pendaftaran',
            'status' => 'pending_kades',
            'qr_token' => 'token-manual-test-12345678',
        ]);

        $this->actingAs($this->kades)->post("/admin/letter-requests/{$letter2->id}/approve-kades", [
            'letter_number' => '470/KHUSUS-99/DS/2026',
            'notes' => 'Disahkan dengan nomor register khusus',
        ]);

        $letter2->refresh();
        $this->assertEquals('approved', $letter2->status);
        $this->assertEquals('470/KHUSUS-99/DS/2026', $letter2->letter_number);
    }

    /**
     * Test konten surat yang sudah disahkan dibekukan (snapshotted) dan kebal perubahan template di masa depan.
     */
    public function test_approved_letter_content_is_snapshotted_and_immutable(): void
    {
        $this->actingAs($this->warga)->post('/citizen/letters', [
            'letter_template_id' => $this->sktmTemplate->id,
            'purpose' => 'Pengajuan beasiswa kuliah tahun 2026',
        ]);

        $letter = LetterRequest::where('user_id', $this->warga->id)->latest('id')->firstOrFail();

        // Bypass RT & Sahkan oleh Kades
        $this->actingAs($this->perangkat)->post("/admin/letter-requests/{$letter->id}/bypass-rt");
        $this->actingAs($this->kades)->post("/admin/letter-requests/{$letter->id}/approve-kades");

        $letter->refresh();
        $this->assertEquals('approved', $letter->status);
        $this->assertNotNull($letter->final_content);
        $this->assertStringContainsString('Budi Santoso', $letter->final_content);
        $this->assertStringContainsString('Pengajuan beasiswa kuliah tahun 2026', $letter->final_content);

        // Ubah template asli di masa depan
        $this->sktmTemplate->update([
            'content_template' => '<p>REDAKSI BARU SKTM TELAH DIUBAH TOTAL OLEH ADMIN</p>',
        ]);

        // Ubah biodata warga di masa depan
        $this->residentWarga->update([
            'name' => 'Budi Santoso Gelar Baru',
        ]);

        // Verifikasi bahwa konten surat yang sudah terbit tetap menggunakan snapshot asli
        $letterService = app(\App\Services\LetterService::class);
        $renderedContent = $letterService->parseTemplateContent($letter);

        $this->assertStringContainsString('Budi Santoso', $renderedContent);
        $this->assertStringNotContainsString('Budi Santoso Gelar Baru', $renderedContent);
        $this->assertStringNotContainsString('REDAKSI BARU SKTM TELAH DIUBAH TOTAL', $renderedContent);

        // PDF juga harus tetap menghasilkan konten snapshot asli
        $pdfService = app(\App\Services\LetterPdfService::class);
        $pdf = $pdfService->generatePdf($letter);
        $pdfOutput = $pdf->output();

        $this->assertNotEmpty($pdfOutput);
    }
}
