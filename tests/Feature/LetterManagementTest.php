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
}
