<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndRbacTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;
    /**
     * Test login page is accessible.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('SiDesa');
    }

    /**
     * Test public home page renders using active theme.
     */
    public function test_public_home_page_renders_with_theme(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Desa Sukamaju');
    }

    /**
     * Test unauthenticated access to admin dashboard redirects to login.
     */
    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test superadmin can access admin dashboard.
     */
    public function test_superadmin_can_access_admin_dashboard(): void
    {
        $superadmin = User::where('email', 'admin@sidesa.id')->first();
        $this->assertNotNull($superadmin);

        $response = $this->actingAs($superadmin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Super Administrator');
    }

    /**
     * Test kades can access admin dashboard.
     */
    public function test_kades_can_access_admin_dashboard(): void
    {
        $kades = User::where('email', 'kades@sidesa.id')->first();
        $this->assertNotNull($kades);

        $response = $this->actingAs($kades)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Kepala Desa');
    }

    /**
     * Test perangkat can access admin dashboard.
     */
    public function test_perangkat_can_access_admin_dashboard(): void
    {
        $perangkat = User::where('email', 'perangkat@sidesa.id')->first();
        $this->assertNotNull($perangkat);

        $response = $this->actingAs($perangkat)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Perangkat Desa');
    }

    /**
     * Test warga (citizen) is forbidden from accessing admin dashboard.
     */
    public function test_warga_cannot_access_admin_dashboard(): void
    {
        $warga = User::where('email', 'warga@sidesa.id')->first();
        $this->assertNotNull($warga);

        $response = $this->actingAs($warga)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    /**
     * Test login with username instead of email works.
     */
    public function test_login_with_username(): void
    {
        $response = $this->post('/login', [
            'login' => 'superadmin',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    /**
     * Test integrasi ttpryg/auth-user RbacManager dan entity.
     */
    public function test_ttpryg_auth_user_rbac_manager_integration(): void
    {
        /** @var \Ttpryg\AuthUser\Services\RbacManager $rbacManager */
        $rbacManager = app(\Ttpryg\AuthUser\Services\RbacManager::class);
        $this->assertNotNull($rbacManager);

        /** @var \Ttpryg\AuthUser\Contracts\UserRepositoryInterface $userRepo */
        $userRepo = app(\Ttpryg\AuthUser\Contracts\UserRepositoryInterface::class);
        $user = $userRepo->findByEmail('admin@sidesa.id');
        $this->assertNotNull($user);

        $loadedUser = $rbacManager->loadUserWithRbac($user);
        $this->assertTrue($loadedUser->hasRole('superadmin'));
        $this->assertTrue($loadedUser->hasPermission('admin.access'));
    }
}
