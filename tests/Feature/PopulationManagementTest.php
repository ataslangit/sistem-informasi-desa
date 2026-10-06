<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Family;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PopulationManagementTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::where('email', 'admin@sidesa.id')->firstOrFail();
    }

    /**
     * Test daftar kartu keluarga dapat diakses.
     */
    public function test_family_index_is_accessible(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/families');
        $response->assertStatus(200);
        $response->assertSee('Daftar Kartu Keluarga');
        $response->assertSee('3201011202150001');
    }

    /**
     * Test tambah kartu keluarga baru dengan validasi 16 digit.
     */
    public function test_can_create_new_family_with_valid_16_digit_card_number(): void
    {
        $familyData = [
            'family_card_number' => '3201019999990001',
            'address' => 'Jl. Mawar No. 10',
            'rt' => '002',
            'rw' => '003',
            'hamlet' => 'Dusun Mekar Sari',
            'postal_code' => '40123',
            'economic_status' => 'mampu',
        ];

        $response = $this->actingAs($this->adminUser)->post('/admin/families', $familyData);
        $response->assertRedirect();

        $this->assertDatabaseHas('families', [
            'family_card_number' => '3201019999990001',
            'hamlet' => 'Dusun Mekar Sari',
        ]);
    }

    /**
     * Test validasi nomor KK menolak jika kurang atau lebih dari 16 digit.
     */
    public function test_rejects_invalid_family_card_number(): void
    {
        $response = $this->actingAs($this->adminUser)->post('/admin/families', [
            'family_card_number' => '12345', // kurang dari 16
            'rt' => '001',
            'rw' => '001',
            'economic_status' => 'mampu',
        ]);

        $response->assertSessionHasErrors('family_card_number');
    }

    /**
     * Test detail kartu keluarga menampilkan anggota keluarga.
     */
    public function test_family_show_displays_members(): void
    {
        $family = Family::firstOrFail();
        $response = $this->actingAs($this->adminUser)->get("/admin/families/{$family->id}");

        $response->assertStatus(200);
        $response->assertSee($family->family_card_number);
    }

    /**
     * Test daftar penduduk dapat diakses dan menampilkan data.
     */
    public function test_resident_index_is_accessible(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/residents');
        $response->assertStatus(200);
        $response->assertSee('Buku Induk Penduduk');
        $response->assertSee('Budi Santoso');
    }

    /**
     * Test tambah penduduk baru dengan validasi NIK 16 digit.
     */
    public function test_can_create_new_resident_with_valid_nik(): void
    {
        $family = Family::firstOrFail();

        $residentData = [
            'nik' => '3201011111110001',
            'family_id' => $family->id,
            'name' => 'Citra Kirana',
            'birth_place' => 'Bandung',
            'birth_date' => '2000-01-15',
            'gender' => 'P',
            'blood_type' => 'B',
            'religion' => 'Islam',
            'marital_status' => 'Belum Kawin',
            'family_relationship_status' => 'Anak',
            'education_level' => 'S1/D4',
            'occupation' => 'Karyawan Swasta',
            'nationality' => 'WNI',
            'status' => 'active',
        ];

        $response = $this->actingAs($this->adminUser)->post('/admin/residents', $residentData);
        $response->assertRedirect();

        $this->assertDatabaseHas('residents', [
            'nik' => '3201011111110001',
            'name' => 'Citra Kirana',
        ]);
    }

    /**
     * Test validasi menolak NIK yang bukan 16 digit angka.
     */
    public function test_rejects_invalid_nik(): void
    {
        $response = $this->actingAs($this->adminUser)->post('/admin/residents', [
            'nik' => '320101ABCDEF0001', // huruf bukan angka
            'name' => 'Invalid NIK User',
            'birth_place' => 'Bogor',
            'birth_date' => '1995-01-01',
            'gender' => 'L',
            'religion' => 'Islam',
            'marital_status' => 'Belum Kawin',
            'family_relationship_status' => 'Anak',
            'education_level' => 'SMA Sederajat',
            'occupation' => 'Pelajar',
            'nationality' => 'WNI',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('nik');
    }

    /**
     * Test pencatatan peristiwa kematian mengubah status penduduk menjadi deceased.
     */
    public function test_record_death_mutation_updates_resident_status(): void
    {
        $resident = Resident::where('status', 'active')->firstOrFail();

        $response = $this->actingAs($this->adminUser)->post('/admin/mutations', [
            'type' => 'death',
            'resident_id' => $resident->id,
            'date' => Carbon::now()->format('Y-m-d'),
            'reason' => 'Meninggal karena sakit',
            'reference_number' => '474.3/99/DS/2026',
        ]);

        $response->assertRedirect(route('admin.mutations.index'));

        $this->assertDatabaseHas('residents', [
            'id' => $resident->id,
            'status' => 'deceased',
        ]);

        $this->assertDatabaseHas('resident_mutations', [
            'resident_id' => $resident->id,
            'type' => 'death',
        ]);
    }

    /**
     * Test pencatatan peristiwa pindah keluar mengubah status penduduk menjadi moved.
     */
    public function test_record_moved_out_mutation_updates_resident_status(): void
    {
        $resident = Resident::where('status', 'active')->firstOrFail();

        $response = $this->actingAs($this->adminUser)->post('/admin/mutations', [
            'type' => 'moved_out',
            'resident_id' => $resident->id,
            'date' => Carbon::now()->format('Y-m-d'),
            'reason' => 'Pindah kerja ke kota lain',
            'target_province' => 'Jawa Timur',
            'target_regency' => 'Kota Surabaya',
            'target_district' => 'Kecamatan Wonokromo',
            'target_village' => 'Kelurahan Darmo',
            'target_address' => 'Jl. Diponegoro No. 45',
            'notes' => 'Alamat baru: Surabaya',
        ]);

        $response->assertRedirect(route('admin.mutations.index'));

        $this->assertDatabaseHas('residents', [
            'id' => $resident->id,
            'status' => 'moved',
        ]);

        $this->assertDatabaseHas('resident_mutations', [
            'resident_id' => $resident->id,
            'type' => 'moved_out',
            'target_province' => 'Jawa Timur',
            'target_regency' => 'Kota Surabaya',
        ]);
    }

    /**
     * Test laporan statistik kependudukan dapat diakses dan menampilkan agregat data.
     */
    public function test_population_statistics_report_is_accessible(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/reports/population');
        $response->assertStatus(200);
        $response->assertSee('Distribusi Kelompok Umur');
        $response->assertSee('Distribusi Tingkat Pendidikan');
        $response->assertSee('Sebaran per Wilayah');
    }

    /**
     * Test admin dapat mengunduh Salinan Kartu Keluarga dalam format PDF dan audit log tercatat.
     */
    public function test_admin_can_download_family_card_pdf_and_audit_trail_recorded(): void
    {
        $family = Family::with('headOfFamily')->firstOrFail();

        $response = $this->actingAs($this->adminUser)->get("/admin/families/{$family->id}/pdf");

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));

        // Cek pencatatan audit log pengunduhan data kependudukan (UU PDP)
        $this->assertDatabaseHas('audit_logs', [
            'entity_type' => 'family',
            'entity_id' => (string) $family->id,
            'event_name' => 'FamilyPdfDownloaded',
            'actor_id' => $this->adminUser->id,
        ]);
    }

    /**
     * Test segmentasi akses role RT pada pengunduhan PDF Kartu Keluarga (Need-to-know basis).
     */
    public function test_rt_user_access_control_for_family_card_pdf_download(): void
    {
        // Buat dua keluarga pada RT berbeda
        $familyRt01 = Family::create([
            'family_card_number' => '3201018888880001',
            'address' => 'Dusun 1 RT 01',
            'rt' => '001',
            'rw' => '001',
            'economic_status' => 'mampu',
        ]);

        $familyRt02 = Family::create([
            'family_card_number' => '3201018888880002',
            'address' => 'Dusun 1 RT 02',
            'rt' => '002',
            'rw' => '001',
            'economic_status' => 'mampu',
        ]);

        // Buat user Ketua RT 001
        $rtUser = User::create([
            'name' => 'Ketua RT 001 Test',
            'username' => 'ketua_rt_test',
            'email' => 'rt_test@sidesa.id',
            'password' => bcrypt('password'),
            'is_active' => true,
            'metadata' => [
                'rt' => '001',
                'rw' => '001',
            ],
        ]);
        $rtUser->assignRole('rt');

        // 1. RT 001 mengunduh KK RT 001 -> Berhasil (200)
        $allowedResponse = $this->actingAs($rtUser)->get("/admin/families/{$familyRt01->id}/pdf");
        $allowedResponse->assertStatus(200);
        $this->assertEquals('application/pdf', $allowedResponse->headers->get('content-type'));

        // 2. RT 001 mencoba mengunduh KK RT 002 -> Ditolak (403)
        $forbiddenResponse = $this->actingAs($rtUser)->get("/admin/families/{$familyRt02->id}/pdf");
        $forbiddenResponse->assertStatus(403);
    }
}
