<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserProfileManagementTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected User $warga;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();
        $this->warga = User::where('email', 'warga@sidesa.id')->firstOrFail();
    }

    /**
     * Test tamu (guest) tidak dapat mengakses halaman profil.
     */
    public function test_guest_cannot_access_profile_page(): void
    {
        $response = $this->get(route('profile.edit'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test pengguna terotentikasi dapat mengakses halaman profil.
     */
    public function test_authenticated_user_can_view_profile_page(): void
    {
        $response = $this->actingAs($this->superadmin)->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Profil');
        $response->assertSee($this->superadmin->name);
        $response->assertSee($this->superadmin->email);
        $response->assertSee('Ganti Kata Sandi');
    }

    /**
     * Test akun warga dapat melihat identitas kependudukan tertaut di halaman profil.
     */
    public function test_citizen_user_sees_linked_resident_info_on_profile(): void
    {
        $response = $this->actingAs($this->warga)->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Identitas Kependudukan Terintegrasi');
        $response->assertSee($this->warga->resident->masked_nik);
    }

    /**
     * Test pengguna dapat memperbarui informasi profilnya.
     */
    public function test_user_can_update_profile_information(): void
    {
        $response = $this->actingAs($this->superadmin)->put(route('profile.update'), [
            'name' => 'Super Administrator Baru',
            'username' => 'superadmin_baru',
            'email' => 'admin_baru@sidesa.id',
            'phone' => '081299998888',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->superadmin->refresh();
        $this->assertEquals('Super Administrator Baru', $this->superadmin->name);
        $this->assertEquals('superadmin_baru', $this->superadmin->username);
        $this->assertEquals('admin_baru@sidesa.id', $this->superadmin->email);
        $this->assertEquals('081299998888', $this->superadmin->metadata['phone']);
    }

    /**
     * Test pembaruan profil gagal jika email sudah digunakan pengguna lain.
     */
    public function test_profile_update_fails_on_duplicate_email(): void
    {
        $response = $this->actingAs($this->superadmin)->put(route('profile.update'), [
            'name' => 'Nama Baru',
            'username' => 'admin_unik',
            'email' => $this->warga->email, // Email milik akun warga
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test pengguna dapat mengganti kata sandi dengan kata sandi lama yang valid.
     */
    public function test_user_can_update_password(): void
    {
        $response = $this->actingAs($this->superadmin)->put(route('profile.password'), [
            'current_password' => 'password',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->superadmin->refresh();
        $this->assertTrue(Hash::check('newpassword123', $this->superadmin->password));

        // Verifikasi pengguna dapat login dengan kata sandi baru
        $this->post(route('logout'));
        $loginResponse = $this->post(route('login.post'), [
            'login' => $this->superadmin->username,
            'password' => 'newpassword123',
        ]);
        $loginResponse->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->superadmin);
    }

    /**
     * Test ganti kata sandi gagal jika kata sandi lama salah.
     */
    public function test_password_update_fails_if_current_password_is_incorrect(): void
    {
        $response = $this->actingAs($this->superadmin)->put(route('profile.password'), [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHasErrors('current_password');
    }

    /**
     * Test ganti kata sandi gagal jika konfirmasi tidak cocok.
     */
    public function test_password_update_fails_if_confirmation_does_not_match(): void
    {
        $response = $this->actingAs($this->superadmin)->put(route('profile.password'), [
            'current_password' => 'password',
            'password' => 'newpassword123',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
