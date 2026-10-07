<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Family;
use App\Models\Permission;
use App\Models\Resident;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserAndRoleManagementTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected User $kades;

    protected User $warga;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();
        $this->kades = User::where('email', 'kades@sidesa.id')->firstOrFail();
        $this->warga = User::where('email', 'warga@sidesa.id')->firstOrFail();
    }

    /**
     * Test superadmin can view users index with stats and filters.
     */
    public function test_superadmin_can_view_users_index(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('Manajemen Pengguna');
        $response->assertSee('Super Administrator');
        $response->assertSee('H. Mulyadi, S.Sos.');
        $response->assertSee('Total Akun');
    }

    /**
     * Test superadmin can search and filter users.
     */
    public function test_superadmin_can_search_and_filter_users(): void
    {
        $searchResponse = $this->actingAs($this->superadmin)->get('/admin/users?keyword=Mulyadi');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('H. Mulyadi, S.Sos.');

        $roleResponse = $this->actingAs($this->superadmin)->get('/admin/users?role=rt');
        $roleResponse->assertStatus(200);
        $roleResponse->assertSee('Sutrisno');
    }

    /**
     * Test superadmin can create a new user.
     */
    public function test_superadmin_can_create_new_user(): void
    {
        $response = $this->actingAs($this->superadmin)->post('/admin/users', [
            'name' => 'Budi Santoso',
            'username' => 'budi_santoso',
            'email' => 'budi@sidesa.id',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
            'role' => 'perangkat',
            'phone' => '081299998888',
            'jabatan' => 'Kaur Keuangan',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'username' => 'budi_santoso',
            'email' => 'budi@sidesa.id',
            'is_active' => true,
        ]);

        $user = User::where('username', 'budi_santoso')->firstOrFail();
        $this->assertTrue($user->hasRole('perangkat'));
        $this->assertTrue(Hash::check('secret1234', $user->password));
        $this->assertEquals('Kaur Keuangan', $user->metadata['jabatan']);
    }

    /**
     * Test validation on user creation.
     */
    public function test_validation_fails_on_duplicate_username_or_email(): void
    {
        $response = $this->actingAs($this->superadmin)->post('/admin/users', [
            'name' => 'Duplikat User',
            'username' => 'superadmin',
            'email' => 'admin@sidesa.id',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
            'role' => 'invalid_role',
        ]);

        $response->assertSessionHasErrors(['username', 'email', 'password', 'role']);
    }

    /**
     * Test superadmin can update an existing user.
     */
    public function test_superadmin_can_update_user(): void
    {
        $user = User::where('username', 'perangkat')->firstOrFail();

        $response = $this->actingAs($this->superadmin)->put('/admin/users/'.$user->id, [
            'name' => 'Ahmad Fauzi, S.E.',
            'username' => 'ahmad_fauzi_se',
            'email' => 'ahmad.fauzi@sidesa.id',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'role' => 'kades',
            'phone' => '081233334444',
            'jabatan' => 'Sekretaris Desa',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals('Ahmad Fauzi, S.E.', $user->name);
        $this->assertEquals('ahmad_fauzi_se', $user->username);
        $this->assertTrue($user->hasRole('kades'));
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    /**
     * Test superadmin cannot deactivate or delete own account.
     */
    public function test_superadmin_cannot_deactivate_or_delete_self(): void
    {
        $toggleResponse = $this->actingAs($this->superadmin)->patch('/admin/users/'.$this->superadmin->id.'/toggle-status');
        $toggleResponse->assertSessionHas('error');
        $this->assertTrue($this->superadmin->fresh()->is_active);

        $deleteResponse = $this->actingAs($this->superadmin)->delete('/admin/users/'.$this->superadmin->id);
        $deleteResponse->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->superadmin->id]);
    }

    /**
     * Test toggle user active status.
     */
    public function test_superadmin_can_toggle_user_status(): void
    {
        $user = User::where('username', 'perangkat')->firstOrFail();
        $this->assertTrue($user->is_active);

        $response = $this->actingAs($this->superadmin)->patch('/admin/users/'.$user->id.'/toggle-status');
        $response->assertSessionHas('success');
        $this->assertFalse($user->fresh()->is_active);
    }

    /**
     * Test superadmin can delete another user.
     */
    public function test_superadmin_can_delete_user(): void
    {
        $user = User::where('username', 'perangkat')->firstOrFail();

        $response = $this->actingAs($this->superadmin)->delete('/admin/users/'.$user->id);
        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /**
     * Test superadmin can view roles index and show detail.
     */
    public function test_superadmin_can_view_roles(): void
    {
        $indexResponse = $this->actingAs($this->superadmin)->get('/admin/roles');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Role & Hak Akses');
        $indexResponse->assertSee('Super Administrator');
        $indexResponse->assertSee('Kepala Desa');

        $kadesRole = Role::where('name', 'kades')->firstOrFail();
        $showResponse = $this->actingAs($this->superadmin)->get('/admin/roles/'.$kadesRole->id);
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Konfigurasi Hak Akses: Kepala Desa');
        $showResponse->assertSee('Pengguna Terdaftar');
    }

    /**
     * Test superadmin can update role permissions.
     */
    public function test_superadmin_can_update_role_permissions(): void
    {
        $rtRole = Role::where('name', 'rt')->firstOrFail();
        $newPerm = Permission::where('name', 'reports.view')->firstOrFail();

        $response = $this->actingAs($this->superadmin)->put('/admin/roles/'.$rtRole->id.'/permissions', [
            'permissions' => [$newPerm->id],
        ]);

        $response->assertRedirect('/admin/roles');
        $response->assertSessionHas('success');

        $this->assertTrue($rtRole->fresh()->permissions->contains('id', $newPerm->id));
    }

    /**
     * Test non-superadmin cannot access user & role management.
     */
    public function test_non_superadmin_cannot_access_user_and_role_management(): void
    {
        $kadesResponse = $this->actingAs($this->kades)->get('/admin/users');
        $kadesResponse->assertStatus(403);

        $wargaResponse = $this->actingAs($this->warga)->get('/admin/users');
        $wargaResponse->assertStatus(403);

        $rolesResponse = $this->actingAs($this->kades)->get('/admin/roles');
        $rolesResponse->assertStatus(403);
    }

    /**
     * Test pembuatan akun peran warga gagal jika tidak ditautkan dengan NIK data penduduk desa.
     */
    public function test_warga_user_creation_fails_without_resident(): void
    {
        $response = $this->actingAs($this->superadmin)->post('/admin/users', [
            'name' => 'Warga Tanpa NIK',
            'username' => 'warga_tanpa_nik',
            'email' => 'warga_tanpa_nik@desa.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'warga',
        ]);

        $response->assertSessionHasErrors(['resident_id']);
        $this->assertDatabaseMissing('users', ['username' => 'warga_tanpa_nik']);
    }

    /**
     * Test pembuatan akun peran warga berhasil jika ditautkan dengan data penduduk desa yang valid.
     */
    public function test_warga_user_creation_succeeds_when_linked_to_resident(): void
    {
        $family = Family::first();
        $resident = Resident::create([
            'family_id' => $family?->id,
            'nik' => '3201019999990001',
            'name' => 'Warga Calon Pengguna',
            'birth_place' => 'Bogor',
            'birth_date' => '1992-08-17',
            'gender' => 'L',
            'blood_type' => 'A',
            'religion' => 'Islam',
            'marital_status' => 'Kawin',
            'family_relationship_status' => 'Kepala Keluarga',
            'education_level' => 'SMA/Sederajat',
            'occupation' => 'Wiraswasta',
            'nationality' => 'WNI',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->superadmin)->post('/admin/users', [
            'name' => 'Nama Acak Di Form',
            'username' => 'warga_terdaftar',
            'email' => 'warga_terdaftar@desa.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'warga',
            'resident_id' => $resident->id,
        ]);

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        $user = User::where('username', 'warga_terdaftar')->firstOrFail();
        $this->assertTrue($user->hasRole('warga'));
        $this->assertEquals('Warga Calon Pengguna', $user->name);
        $this->assertEquals('3201019999990001', $user->nik);
        $this->assertEquals('320101******0001', $user->masked_nik);
        $this->assertEquals($user->id, $resident->fresh()->user_id);
    }

    /**
     * Test pembuatan akun peran RT menyimpan wilayah tugas RT/RW dan NIK.
     */
    public function test_rt_user_creation_stores_rt_rw_and_nik(): void
    {
        $response = $this->actingAs($this->superadmin)->post('/admin/users', [
            'name' => 'Pak RT 05',
            'username' => 'ketua_rt05',
            'email' => 'rt05@desa.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'rt',
            'nik' => '3201015505050001',
            'rt' => '005',
            'rw' => '002',
            'phone' => '081234567899',
        ]);

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        $user = User::where('username', 'ketua_rt05')->firstOrFail();
        $this->assertTrue($user->hasRole('rt'));
        $this->assertEquals('005', $user->getAssignedRt());
        $this->assertEquals('002', $user->getAssignedRw());
        $this->assertEquals('3201015505050001', $user->nik);
        $this->assertEquals('320101******0001', $user->masked_nik);
    }

    /**
     * Test tampilan daftar user menampilkan lencana NIK tersamar dan penetapan RT.
     */
    public function test_users_index_displays_masked_nik_and_rt_badges(): void
    {
        $user = User::create([
            'name' => 'Ketua RT Teladan',
            'username' => 'rt_teladan',
            'email' => 'rt_teladan@desa.id',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'metadata' => [
                'nik' => '3201018808080001',
                'rt' => '007',
                'rw' => '003',
            ],
        ]);
        $user->assignRole('rt');

        $response = $this->actingAs($this->superadmin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('320101******0001');
        $response->assertSee('RT 007');
    }
}
