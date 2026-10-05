<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use App\Models\Resident;
use App\Models\Setting;
use App\Models\User;
use App\Services\LetterService;
use App\Services\TteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertifiedDigitalSignatureTteComplianceTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected User $kades;

    protected User $warga;

    protected Resident $residentWarga;

    protected LetterTemplate $sktmTemplate;

    protected LetterService $letterService;

    protected TteService $tteService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();
        $this->kades = User::where('email', 'kades@sidesa.id')->firstOrFail();
        $this->warga = User::where('email', 'warga@sidesa.id')->firstOrFail();

        $this->residentWarga = Resident::where('nik', '3201011508900001')->firstOrFail();
        $this->sktmTemplate = LetterTemplate::where('code', 'SKTM')->firstOrFail();

        $this->tteService = app(TteService::class);
        $this->letterService = app(LetterService::class);
    }

    /**
     * Test penghitungan SHA-256 document checksum digest bersifat deterministik dan sensitif terhadap integritas.
     */
    public function test_tte_service_computes_deterministic_sha256_document_hash(): void
    {
        $request = $this->letterService->createRequest(
            $this->warga,
            $this->residentWarga,
            $this->sktmTemplate,
            'Persyaratan beasiswa kuliah'
        );

        $request->letter_number = '470/001/SKTM/Ds/2026';
        $request->signed_at = now();
        $request->final_content = 'Isi naskah resmi surat keterangan tidak mampu.';

        $hash1 = $this->tteService->calculateDocumentHash($request);
        $this->assertEquals(64, strlen($hash1));

        // Harus deterministik
        $hash2 = $this->tteService->calculateDocumentHash($request);
        $this->assertEquals($hash1, $hash2);

        // Jika konten diubah 1 karakter, hash berubah drastis (Avalanche effect SHA-256)
        $request->final_content = 'Isi naskah resmi surat keterangan tidak mampu!';
        $tamperedHash = $this->tteService->calculateDocumentHash($request);
        $this->assertNotEquals($hash1, $tamperedHash);
    }

    /**
     * Test alur pengesahan Kepala Desa otomatis menghasilkan TTE Tersertifikasi BSrE BSSN.
     */
    public function test_kades_approval_automatically_signs_letter_with_certified_bsre_tte(): void
    {
        $letterRequest = $this->letterService->createRequest(
            $this->warga,
            $this->residentWarga,
            $this->sktmTemplate,
            'Keperluan permohonan bantuan pendidikan'
        );

        // Bypass RT & verifikasi staf langsung ke pending_kades
        $this->letterService->bypassRtAndVerify($letterRequest, $this->superadmin, 'Bypass berkas fisik');
        $this->assertEquals(LetterRequest::STATUS_PENDING_KADES, $letterRequest->fresh()->status);

        // Kades menyetujui dan menandatangani secara elektronik
        $response = $this->actingAs($this->kades)->post("/admin/letter-requests/{$letterRequest->id}/approve-kades", [
            'letter_number' => '470/099/SKTM/Ds/2026',
            'notes' => 'Disahkan secara elektronik dengan sertifikat BSrE BSSN',
        ]);

        $response->assertRedirect("/admin/letter-requests/{$letterRequest->id}");

        $updatedLetter = $letterRequest->fresh();
        $this->assertEquals(LetterRequest::STATUS_APPROVED, $updatedLetter->status);
        $this->assertEquals('470/099/SKTM/Ds/2026', $updatedLetter->letter_number);

        // Verifikasi atribut yuridis TTE tersimpan
        $this->assertEquals(LetterRequest::SIGNATURE_TYPE_CERTIFIED, $updatedLetter->signature_type);
        $this->assertTrue($updatedLetter->isCertifiedTte());
        $this->assertEquals(LetterRequest::PROVIDER_BSRE, $updatedLetter->tte_provider);
        $this->assertStringContainsString('Balai Sertifikasi Elektronik', (string) $updatedLetter->certificate_issuer);
        $this->assertStringStartsWith('BSRE-BSSN-', (string) $updatedLetter->certificate_serial_number);
        $this->assertNotEmpty($updatedLetter->document_hash);
        $this->assertEquals(64, strlen($updatedLetter->document_hash));
        $this->assertNotEmpty($updatedLetter->signature_hash);
        $this->assertEquals($this->kades->name, $updatedLetter->signer_name);
        $this->assertNotNull($updatedLetter->tte_timestamp);
        $this->assertFalse($updatedLetter->is_tampered);
    }

    /**
     * Test halaman publik verifikasi scan QR menampilkan keabsahan TTE Tersertifikasi BSrE BSSN dan UU ITE No. 1/2024.
     */
    public function test_public_verification_page_verifies_valid_bsre_certified_document(): void
    {
        $letterRequest = $this->letterService->createRequest(
            $this->warga,
            $this->residentWarga,
            $this->sktmTemplate,
            'Keperluan beasiswa pemuda berprestasi'
        );

        $this->letterService->bypassRtAndVerify($letterRequest, $this->superadmin);
        $this->letterService->approveByKades($letterRequest, $this->kades, 'Disahkan');

        $approvedLetter = $letterRequest->fresh();

        $response = $this->get("/verify/letter/{$approvedLetter->qr_token}");
        $response->assertStatus(200);
        $response->assertSee('DOKUMEN SAH &amp; TERVERIFIKASI', false);
        $response->assertSee('TTE TERSERTIFIKASI (BSrE BSSN)');
        $response->assertSee('Balai Sertifikasi Elektronik (BSrE)');
        $response->assertSee('UU No. 1/2024');
        $response->assertSee('PP 71/2019');
        $response->assertSee($approvedLetter->letter_number);
        $response->assertSee($approvedLetter->certificate_serial_number);
        $response->assertSee($approvedLetter->document_hash);
    }

    /**
     * Test verifikasi mendeteksi jika isi dokumen dirusak atau dimodifikasi secara ilegal setelah disahkan (Anti-Tamper).
     */
    public function test_public_verification_detects_tampered_document_when_content_modified_post_signing(): void
    {
        $letterRequest = $this->letterService->createRequest(
            $this->warga,
            $this->residentWarga,
            $this->sktmTemplate,
            'Keperluan izin usaha'
        );

        $this->letterService->bypassRtAndVerify($letterRequest, $this->superadmin);
        $this->letterService->approveByKades($letterRequest, $this->kades, 'Disahkan');

        $approvedLetter = $letterRequest->fresh();

        // Simulasi kejahatan siber: Isi surat dimodifikasi di database secara ilegal (Tampering)
        $approvedLetter->final_content = $approvedLetter->final_content.' [TAMBAHAN TEKS PALSU TANPA IZIN]';
        $approvedLetter->save();

        // Buka halaman verifikasi
        $response = $this->get("/verify/letter/{$approvedLetter->qr_token}");
        $response->assertStatus(200);
        $response->assertSee('DOKUMEN TIDAK VALID / INTEGRITAS RUSAK');
        $response->assertSee('telah diubah secara ilegal');

        // Flag tampered tercatat di database
        $this->assertTrue($approvedLetter->fresh()->is_tampered);
    }

    /**
     * Test unduh PDF surat memuat keterangan TTE Tersertifikasi BSrE BSSN dan SHA-256 hash digest.
     */
    public function test_official_pdf_includes_bsre_certified_tte_signature_and_document_hash(): void
    {
        $letterRequest = $this->letterService->createRequest(
            $this->warga,
            $this->residentWarga,
            $this->sktmTemplate,
            'Keperluan pembuatan rekening bank'
        );

        $this->letterService->bypassRtAndVerify($letterRequest, $this->superadmin);
        $this->letterService->approveByKades($letterRequest, $this->kades, 'Disahkan');

        $approvedLetter = $letterRequest->fresh();

        $response = $this->actingAs($this->warga)->get("/citizen/letters/{$approvedLetter->id}/pdf");
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Test admin dapat melihat dan memperbarui konfigurasi TTE BSrE BSSN.
     */
    public function test_admin_can_view_and_update_tte_settings(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/tte-settings');
        $response->assertStatus(200);
        $response->assertSee('Tanda Tangan Elektronik (TTE) Tersertifikasi');
        $response->assertSee('BSrE BSSN');
        $response->assertSee('UU No. 1 Tahun 2024');

        $updateResponse = $this->actingAs($this->superadmin)->post('/admin/tte-settings', [
            'tte_provider' => 'bsre_bssn',
            'tte_bsre_url' => 'https://esign.bssn.go.id/api/v2/sign',
            'tte_bsre_client_id' => 'sidesa-custom-client-id',
            'tte_bsre_issuer' => 'Balai Sertifikasi Elektronik BSSN RI',
            'tte_sandbox_mode' => '1',
        ]);

        $updateResponse->assertRedirect('/admin/tte-settings');

        $this->assertEquals('https://esign.bssn.go.id/api/v2/sign', Setting::get('tte_bsre_url'));
        $this->assertEquals('sidesa-custom-client-id', Setting::get('tte_bsre_client_id'));
        $this->assertEquals('Balai Sertifikasi Elektronik BSSN RI', Setting::get('tte_bsre_issuer'));
        $this->assertEquals('1', Setting::get('tte_sandbox_mode'));
    }
}
