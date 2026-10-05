<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Family;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PdpComplianceAndDataProtectionTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected User $rtUser;

    protected Family $familyRt01;

    protected Family $familyRt02;

    protected Resident $residentRt01;

    protected Resident $residentRt02;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();

        // 1. Buat dua keluarga di RT berbeda
        $this->familyRt01 = Family::create([
            'family_card_number' => '3201010101010001',
            'address' => 'Jl. Mawar No. 1',
            'rt' => '001',
            'rw' => '002',
            'hamlet' => 'Dusun 1',
            'postal_code' => '40111',
            'economic_status' => 'mampu',
        ]);

        $this->familyRt02 = Family::create([
            'family_card_number' => '3201010101010002',
            'address' => 'Jl. Melati No. 2',
            'rt' => '002',
            'rw' => '002',
            'hamlet' => 'Dusun 1',
            'postal_code' => '40111',
            'economic_status' => 'mampu',
        ]);

        // 2. Buat penduduk pada masing-masing RT
        $this->residentRt01 = Resident::create([
            'family_id' => $this->familyRt01->id,
            'nik' => '3201010101010011',
            'name' => 'Warga RT Satu',
            'birth_place' => 'Bandung',
            'birth_date' => '1990-01-01',
            'gender' => 'L',
            'religion' => 'Islam',
            'marital_status' => 'Kawin',
            'family_relationship_status' => 'Kepala Keluarga',
            'education_level' => 'S1',
            'occupation' => 'Wiraswasta',
            'nationality' => 'WNI',
            'status' => 'active',
        ]);
        $this->familyRt01->update(['head_of_family_id' => $this->residentRt01->id]);

        $this->residentRt02 = Resident::create([
            'family_id' => $this->familyRt02->id,
            'nik' => '3201010101010022',
            'name' => 'Warga RT Dua',
            'birth_place' => 'Bandung',
            'birth_date' => '1992-02-02',
            'gender' => 'P',
            'religion' => 'Islam',
            'marital_status' => 'Belum Kawin',
            'family_relationship_status' => 'Kepala Keluarga',
            'education_level' => 'SMA',
            'occupation' => 'Karyawan Swasta',
            'nationality' => 'WNI',
            'status' => 'active',
        ]);
        $this->familyRt02->update(['head_of_family_id' => $this->residentRt02->id]);

        // 3. Buat user Ketua RT 001
        $this->rtUser = User::create([
            'name' => 'Ketua RT 001',
            'username' => 'ketua_rt_001',
            'email' => 'rt001@sidesa.id',
            'password' => bcrypt('password'),
            'is_active' => true,
            'metadata' => [
                'rt' => '001',
                'rw' => '002',
            ],
        ]);
        $this->rtUser->assignRole('rt');
    }

    /**
     * Test data masking pada model Resident dan Family.
     */
    public function test_resident_and_family_pii_masking(): void
    {
        $this->assertEquals('320101******0011', $this->residentRt01->masked_nik);
        $this->assertEquals('320101******0001', $this->familyRt01->masked_family_card_number);
    }

    /**
     * Test akun RT hanya melihat warga di wilayah RT-nya sendiri pada indeks penduduk.
     */
    public function test_rt_user_sees_only_residents_in_their_assigned_rt(): void
    {
        $response = $this->actingAs($this->rtUser)->get(route('admin.residents.index'));

        $response->assertStatus(200);
        $response->assertSee('Warga RT Satu');
        $response->assertDontSee('Warga RT Dua');
        $response->assertSee('Segmentasi Akses Wilayah RT 001');
    }

    /**
     * Test admin/kades melihat semua warga desa tanpa filter wilayah RT.
     */
    public function test_superadmin_sees_all_residents(): void
    {
        $response = $this->actingAs($this->superadmin)->get(route('admin.residents.index'));

        $response->assertStatus(200);
        $response->assertSee('Warga RT Satu');
        $response->assertSee('Warga RT Dua');
    }

    /**
     * Test akun RT diblokir jika mencoba mengakses detail warga di luar RT-nya (403).
     */
    public function test_rt_user_forbidden_from_viewing_resident_outside_their_rt(): void
    {
        // Akses warga RT sendiri -> Berhasil 200
        $responseOwn = $this->actingAs($this->rtUser)->get(route('admin.residents.show', $this->residentRt01));
        $responseOwn->assertStatus(200);

        // Akses warga luar RT -> Ditolak 403
        $responseOther = $this->actingAs($this->rtUser)->get(route('admin.residents.show', $this->residentRt02));
        $responseOther->assertStatus(403);
    }

    /**
     * Test akun RT diblokir jika mencoba mengakses detail KK di luar RT-nya (403).
     */
    public function test_rt_user_forbidden_from_viewing_family_outside_their_rt(): void
    {
        // Akses KK RT sendiri -> Berhasil 200
        $responseOwn = $this->actingAs($this->rtUser)->get(route('admin.families.show', $this->familyRt01));
        $responseOwn->assertStatus(200);

        // Akses KK luar RT -> Ditolak 403
        $responseOther = $this->actingAs($this->rtUser)->get(route('admin.families.show', $this->familyRt02));
        $responseOther->assertStatus(403);
    }

    /**
     * Test pembacaan data penduduk dan kartu keluarga mencatat audit log akses (UU PDP).
     */
    public function test_viewing_resident_and_family_records_audit_trail_access(): void
    {
        $this->actingAs($this->superadmin)->get(route('admin.residents.show', $this->residentRt01));

        $this->assertDatabaseHas('audit_logs', [
            'event_name' => 'ResidentViewed',
            'entity_type' => 'resident',
            'entity_id' => (string) $this->residentRt01->id,
            'actor_id' => $this->superadmin->id,
        ]);

        $this->actingAs($this->superadmin)->get(route('admin.families.show', $this->familyRt01));

        $this->assertDatabaseHas('audit_logs', [
            'event_name' => 'FamilyViewed',
            'entity_type' => 'family',
            'entity_id' => (string) $this->familyRt01->id,
            'actor_id' => $this->superadmin->id,
        ]);
    }
}
