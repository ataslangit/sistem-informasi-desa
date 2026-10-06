<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\InformationObjection;
use App\Models\InformationRequest;
use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSidebarBadgeCountTest extends TestCase
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
     * Test badge tidak tampil bila tidak ada antrean menunggu.
     */
    public function test_sidebar_does_not_show_pending_badges_when_count_is_zero(): void
    {
        // Pastikan tidak ada data pending
        InformationRequest::query()->delete();
        InformationObjection::query()->delete();
        LetterRequest::query()->delete();

        $response = $this->actingAs($this->superadmin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertDontSee('permohonan surat menunggu');
        $response->assertDontSee('permohonan informasi menunggu');
        $response->assertDontSee('keberatan informasi menunggu');
    }

    /**
     * Test badge hitungan pending permohonan informasi (PPID) di sidebar.
     */
    public function test_sidebar_shows_ppid_request_pending_badge(): void
    {
        InformationRequest::create([
            'ticket_number' => 'INF-20261006-0001',
            'applicant_name' => 'Budi Santoso',
            'applicant_nik' => '3201011234560001',
            'applicant_phone' => '081234567890',
            'applicant_email' => 'budi@example.com',
            'applicant_address' => 'Dusun 1 RT 01 RW 01',
            'information_requested' => 'Rincian Realisasi APBDes 2025',
            'purpose' => 'Riset Akademik',
            'acquisition_way' => 'Unduh Salinan Digital',
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($this->superadmin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Permohonan Informasi');
        $response->assertSee('1 permohonan informasi menunggu');
    }

    /**
     * Test badge hitungan pending keberatan informasi (PPID) di sidebar.
     */
    public function test_sidebar_shows_ppid_objection_pending_badge(): void
    {
        $infoRequest = InformationRequest::create([
            'ticket_number' => 'INF-20261006-0002',
            'applicant_name' => 'Siti Rahma',
            'applicant_nik' => '3201011234560002',
            'applicant_phone' => '081234567891',
            'applicant_email' => 'siti@example.com',
            'applicant_address' => 'Dusun 2 RT 02 RW 01',
            'information_requested' => 'Dokumen RKPDes 2026',
            'purpose' => 'Partisipasi Warga',
            'acquisition_way' => 'Salinan Cetak',
            'status' => 'rejected',
        ]);

        InformationObjection::create([
            'ticket_number' => 'KBR-20261006-0001',
            'information_request_id' => $infoRequest->id,
            'reason_code' => 'rejected',
            'objection_detail' => 'Penolakan informasi tidak disertai pertimbangan hukum memadai.',
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($this->kades)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Keberatan Informasi');
        $response->assertSee('1 keberatan informasi menunggu');
    }

    /**
     * Test badge hitungan surat pending bagi superadmin, kades, dan rt.
     */
    public function test_sidebar_shows_letter_requests_pending_badge_by_role(): void
    {
        LetterRequest::query()->delete();

        // 1. Buat surat status pending_kades
        LetterRequest::create([
            'request_number' => 'REQ-2026-0001',
            'qr_token' => 'qr-token-test-0001-12345678901234',
            'letter_template_id' => $this->sktmTemplate->id,
            'resident_id' => $this->residentWarga->id,
            'user_id' => $this->warga->id,
            'purpose' => 'Beasiswa Sekolah',
            'extra_data' => [],
            'status' => LetterRequest::STATUS_PENDING_KADES,
            'staff_verified_at' => now(),
            'staff_verified_by' => $this->perangkat->id,
        ]);

        // 2. Buat surat status pending_rt
        LetterRequest::create([
            'request_number' => 'REQ-2026-0002',
            'qr_token' => 'qr-token-test-0002-12345678901234',
            'letter_template_id' => $this->sktmTemplate->id,
            'resident_id' => $this->residentWarga->id,
            'user_id' => $this->warga->id,
            'purpose' => 'Surat Pengantar RT',
            'extra_data' => [],
            'status' => LetterRequest::STATUS_PENDING_RT,
        ]);

        // Kades melihat 1 surat menunggu TTE Kades (status pending_kades)
        $responseKades = $this->actingAs($this->kades)->get(route('admin.dashboard'));
        $responseKades->assertStatus(200);
        $responseKades->assertSee('Permohonan Surat');
        $responseKades->assertSee('1 permohonan surat menunggu');

        // RT melihat surat menunggu verifikasi RT (status pending_rt)
        $responseRt = $this->actingAs($this->rt)->get(route('admin.dashboard'));
        $responseRt->assertStatus(200);
        $responseRt->assertSee('Permohonan Surat');
        $responseRt->assertSee('1 permohonan surat menunggu');

        // Superadmin melihat total pending surat (1 pending_kades + 1 pending_rt = 2)
        $responseAdmin = $this->actingAs($this->superadmin)->get(route('admin.dashboard'));
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('Permohonan Surat');
        $responseAdmin->assertSee('2 permohonan surat menunggu');
    }

    /**
     * Test badge hitungan surat bagi akun warga di menu Layanan Mandiri (Surat Saya).
     */
    public function test_sidebar_shows_citizen_pending_letter_badge(): void
    {
        LetterRequest::query()->delete();

        LetterRequest::create([
            'request_number' => 'REQ-2026-0003',
            'qr_token' => 'qr-token-test-0003-12345678901234',
            'letter_template_id' => $this->sktmTemplate->id,
            'resident_id' => $this->residentWarga->id,
            'user_id' => $this->warga->id,
            'purpose' => 'Bantuan Beras',
            'extra_data' => [],
            'status' => LetterRequest::STATUS_PENDING_STAFF,
        ]);

        $responseWarga = $this->actingAs($this->warga)->get(route('citizen.letters.index'));
        $responseWarga->assertStatus(200);
        $responseWarga->assertSee('Surat Saya');
        $responseWarga->assertSee('1 permohonan surat sedang diproses');
    }
}
