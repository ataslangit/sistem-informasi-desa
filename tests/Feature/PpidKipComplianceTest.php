<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\InformationObjection;
use App\Models\InformationRequest;
use App\Models\PublicDocument;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PpidKipComplianceTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected User $kades;

    protected User $perangkat;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();
        $this->kades = User::where('email', 'kades@sidesa.id')->firstOrFail();
        $this->perangkat = User::where('email', 'perangkat@sidesa.id')->firstOrFail();

        Storage::fake('public');
    }

    /**
     * Test halaman publik beranda PPID Desa dapat diakses.
     */
    public function test_public_ppid_index_is_accessible(): void
    {
        $response = $this->get(route('public.ppid.index'));

        $response->assertStatus(200);
        $response->assertSee('PPID Desa');
        $response->assertSee('Maklumat Pelayanan Informasi Publik');
        $response->assertSee('Struktur Organisasi PPID Desa');
    }

    /**
     * Test repositori dokumen publik (DIP) dan unduh berkas.
     */
    public function test_public_documents_repository_and_download(): void
    {
        $file = UploadedFile::fake()->create('lppd_2025.pdf', 500, 'application/pdf');
        $filePath = $file->storeAs('ppid_documents', 'lppd-2025.pdf', 'public');

        $doc = PublicDocument::create([
            'title' => 'Laporan Penyelenggaraan Pemerintahan Desa (LPPD) 2025',
            'slug' => 'lppd-2025',
            'category' => 'berkala',
            'document_type' => 'LPPD',
            'year' => 2025,
            'description' => 'Laporan resmi pertanggungjawaban tahun anggaran 2025.',
            'file_path' => $filePath,
            'file_size' => 500000,
            'file_extension' => 'pdf',
            'download_count' => 0,
            'is_published' => true,
            'published_at' => now(),
            'user_id' => $this->superadmin->id,
        ]);

        $indexResponse = $this->get(route('public.ppid.documents'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Laporan Penyelenggaraan Pemerintahan Desa');
        $indexResponse->assertSee('2025');

        // Test download file
        $downloadResponse = $this->get(route('public.ppid.documents.download', $doc));
        $downloadResponse->assertStatus(200);
        $this->assertEquals(1, $doc->fresh()->download_count);
    }

    /**
     * Test pengajuan permohonan informasi publik secara daring.
     */
    public function test_citizen_can_submit_information_request_online(): void
    {
        $response = $this->post(route('public.ppid.requests.store'), [
            'applicant_name' => 'Budi Pemohon',
            'applicant_nik' => '3201019001010001',
            'applicant_phone' => '081299887766',
            'applicant_email' => 'budi.pemohon@example.com',
            'applicant_address' => 'Kp. Sukamaju RT 02 RW 01',
            'information_requested' => 'Salinan Rincian Anggaran Pembangunan Jalan Desa Tahun 2025',
            'purpose' => 'Kajian transparansi pembangunan desa oleh kelompok pemuda',
            'acquisition_way' => 'online',
        ]);

        $this->assertDatabaseHas('information_requests', [
            'applicant_name' => 'Budi Pemohon',
            'applicant_email' => 'budi.pemohon@example.com',
            'status' => 'submitted',
        ]);

        $createdRequest = InformationRequest::where('applicant_email', 'budi.pemohon@example.com')->firstOrFail();
        $this->assertStringStartsWith('INF-', $createdRequest->ticket_number);

        $response->assertRedirect(route('public.ppid.tracking.show', $createdRequest->ticket_number));
    }

    /**
     * Test pelacakan status tiket permohonan informasi.
     */
    public function test_tracking_information_request_ticket(): void
    {
        $infoRequest = InformationRequest::create([
            'ticket_number' => 'INF-20261005-9999',
            'applicant_name' => 'Siti Pemohon',
            'applicant_phone' => '081200000001',
            'applicant_email' => 'siti@example.com',
            'applicant_address' => 'Jl. Desa No. 10',
            'information_requested' => 'Data Realisasi Dana Desa Tahap 1',
            'purpose' => 'Monitoring anggaran desa',
            'acquisition_way' => 'online',
            'status' => 'submitted',
        ]);

        $response = $this->get(route('public.ppid.tracking.show', 'INF-20261005-9999'));

        $response->assertStatus(200);
        $response->assertSee('INF-20261005-9999');
        $response->assertSee('Siti Pemohon');
        $response->assertSee('Menunggu Verifikasi');
    }

    /**
     * Test alur penanganan permohonan oleh PPID di panel admin (proses dan approve).
     */
    public function test_admin_can_process_and_approve_information_request(): void
    {
        $infoRequest = InformationRequest::create([
            'ticket_number' => 'INF-20261005-8888',
            'applicant_name' => 'Joko Riset',
            'applicant_phone' => '081200000002',
            'applicant_email' => 'joko@example.com',
            'applicant_address' => 'Dusun 2',
            'information_requested' => 'Profil Kelembagaan Bumdes',
            'purpose' => 'Penyusunan skripsi',
            'acquisition_way' => 'online',
            'status' => 'submitted',
        ]);

        // 1. Admin melihat index permohonan
        $indexResponse = $this->actingAs($this->perangkat)->get(route('admin.ppid-requests.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('INF-20261005-8888');

        // 2. Admin memproses permohonan
        $processResponse = $this->actingAs($this->perangkat)->post(route('admin.ppid-requests.process', $infoRequest));
        $processResponse->assertStatus(302);
        $this->assertEquals('processed', $infoRequest->fresh()->status);

        // 3. Admin menyetujui dan memberikan tanggapan tertulis
        $approveFile = UploadedFile::fake()->create('jawaban_bumdes.pdf', 300, 'application/pdf');

        $approveResponse = $this->actingAs($this->perangkat)->post(route('admin.ppid-requests.approve', $infoRequest), [
            'response_text' => 'Bersama ini kami lampirkan dokumen profil kelembagaan BUMDes tahun berjalan.',
            'response_file' => $approveFile,
        ]);

        $approveResponse->assertStatus(302);
        $freshRequest = $infoRequest->fresh();
        $this->assertEquals('approved', $freshRequest->status);
        $this->assertNotNull($freshRequest->response_file_path);
        $this->assertNotNull($freshRequest->responded_at);
        $this->assertEquals($this->perangkat->id, $freshRequest->responded_by);
    }

    /**
     * Test admin dapat menolak permohonan informasi dengan alasan resmi UU KIP.
     */
    public function test_admin_can_reject_information_request_with_reason(): void
    {
        $infoRequest = InformationRequest::create([
            'ticket_number' => 'INF-20261005-7777',
            'applicant_name' => 'Pemohon Anonim',
            'applicant_phone' => '081200000003',
            'applicant_email' => 'anonim@example.com',
            'applicant_address' => 'Luar Desa',
            'information_requested' => 'Rekapitulasi Nomor NIK dan Riwayat Penyakit Seluruh Warga',
            'purpose' => 'Keperluan survei pribadi',
            'acquisition_way' => 'online',
            'status' => 'submitted',
        ]);

        $rejectResponse = $this->actingAs($this->perangkat)->post(route('admin.ppid-requests.reject', $infoRequest), [
            'rejection_reason' => 'Permohonan ditolak karena memuat data pribadi rahasia warga yang dilindungi berdasarkan Pasal 17 huruf h UU No. 14 Tahun 2008 dan UU No. 27 Tahun 2022 (Informasi Dikecualikan).',
        ]);

        $rejectResponse->assertStatus(302);
        $fresh = $infoRequest->fresh();
        $this->assertEquals('rejected', $fresh->status);
        $this->assertStringContainsString('Informasi Dikecualikan', (string) $fresh->rejection_reason);
    }

    /**
     * Test pemohon dapat mengajukan keberatan informasi publik ke Atasan PPID (Kepala Desa).
     */
    public function test_citizen_can_submit_objection_to_village_head(): void
    {
        $infoRequest = InformationRequest::create([
            'ticket_number' => 'INF-20261005-6666',
            'applicant_name' => 'Pemohon Keberatan',
            'applicant_phone' => '081200000004',
            'applicant_email' => 'keberatan@example.com',
            'applicant_address' => 'Dusun 1 RT 01',
            'information_requested' => 'Laporan Realisasi APBDes',
            'purpose' => 'Kajian masyarakat',
            'acquisition_way' => 'online',
            'status' => 'rejected',
            'rejection_reason' => 'Ditolak tanpa penjelasan memadai.',
        ]);

        $response = $this->post(route('public.ppid.objections.store', $infoRequest->ticket_number), [
            'reason_code' => 'rejected',
            'objection_detail' => 'Kami mengajukan keberatan karena informasi APBDes adalah informasi terbuka berkala yang wajib disediakan pemdes.',
        ]);

        $this->assertDatabaseHas('information_objections', [
            'information_request_id' => $infoRequest->id,
            'reason_code' => 'rejected',
            'status' => 'submitted',
        ]);

        $objection = InformationObjection::where('information_request_id', $infoRequest->id)->firstOrFail();
        $this->assertStringStartsWith('KBR-', $objection->ticket_number);

        $response->assertRedirect(route('public.ppid.tracking.show', $objection->ticket_number));
    }

    /**
     * Test Kepala Desa (Atasan PPID) dapat meninjau dan memutuskan tanggapan keberatan.
     */
    public function test_village_head_can_respond_to_objection(): void
    {
        $infoRequest = InformationRequest::create([
            'ticket_number' => 'INF-20261005-5555',
            'applicant_name' => 'Warga Penggugat',
            'applicant_phone' => '081200000005',
            'applicant_email' => 'penggugat@example.com',
            'applicant_address' => 'Dusun 2',
            'information_requested' => 'Dokumen RKPDes',
            'purpose' => 'Pemeriksaan publik',
            'acquisition_way' => 'online',
            'status' => 'rejected',
        ]);

        $objection = InformationObjection::create([
            'ticket_number' => 'KBR-20261005-0001',
            'information_request_id' => $infoRequest->id,
            'reason_code' => 'rejected',
            'objection_detail' => 'Keberatan diajukan atas penolakan dokumen RKPDes.',
            'status' => 'submitted',
        ]);

        // Kepala Desa membuka daftar dan detail keberatan
        $indexResponse = $this->actingAs($this->kades)->get(route('admin.ppid-objections.index'));
        $indexResponse->assertStatus(200);

        $showResponse = $this->actingAs($this->kades)->get(route('admin.ppid-objections.show', $objection));
        $showResponse->assertStatus(200);

        // Kepala Desa menerima keberatan dan memerintahkan PPID memberikan dokumen
        $respondResponse = $this->actingAs($this->kades)->post(route('admin.ppid-objections.respond', $objection), [
            'status' => 'upheld',
            'response_text' => 'Setelah meneliti berkas, Kepala Desa memutuskan Keberatan DITERIMA. Sekretaris Desa selaku PPID diperintahkan untuk memberikan dokumen RKPDes kepada pemohon.',
        ]);

        $respondResponse->assertStatus(302);
        $freshObjection = $objection->fresh();
        $this->assertEquals('upheld', $freshObjection->status);
        $this->assertStringContainsString('Keberatan DITERIMA', (string) $freshObjection->response_text);
        $this->assertEquals($this->kades->id, $freshObjection->responded_by);
    }

    /**
     * Test admin dapat mengelola pengaturan struktur & maklumat PPID Desa.
     */
    public function test_admin_can_update_ppid_settings(): void
    {
        $response = $this->actingAs($this->superadmin)->post(route('admin.ppid-settings.update'), [
            'ppid_leader_name' => 'Bambang Irawan, S.H. (Kades)',
            'ppid_officer_name' => 'Dewi Rahmawati, S.A.P. (Sekdes)',
            'ppid_desk_officers' => "Kaur TU\nKasi Pemerintahan",
            'ppid_maklumat' => 'Maklumat pelayanan informasi publik baru sesuai Perki 1/2018.',
            'ppid_phone' => '081122334455',
            'ppid_email' => 'ppid.baru@sidesa.id',
            'ppid_service_hours' => 'Senin - Jumat: 08.00 - 15.00 WIB',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('settings', [
            'key' => 'ppid_leader_name',
            'value' => 'Bambang Irawan, S.H. (Kades)',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'ppid_officer_name',
            'value' => 'Dewi Rahmawati, S.A.P. (Sekdes)',
        ]);
    }
}
