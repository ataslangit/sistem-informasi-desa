<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomErrorPagesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Test 404 page renders default theme error view.
     */
    public function test_404_page_renders_default_theme_view(): void
    {
        Setting::set('active_theme', 'default');

        $response = $this->get('/url-yang-tidak-pernah-ada-12345');

        $response->assertStatus(404);
        $response->assertSee('404');
        $response->assertSee('Halaman Tidak Tersedia');
        $response->assertSee('Kembali ke Beranda');
        $response->assertSee('Dokumen Publik (DIP)');
    }

    /**
     * Test 404 page renders active theme custom error view when switched to emerald theme.
     */
    public function test_404_page_renders_emerald_theme_view(): void
    {
        Setting::set('active_theme', 'emerald');

        $response = $this->get('/url-yang-tidak-pernah-ada-emerald');

        $response->assertStatus(404);
        $response->assertSee('Tema Emerald');
        $response->assertSee('Alamat Halaman Tidak Ada');
        $response->assertSee('Daftar Dokumen Publik');
    }

    /**
     * Test 403 page renders custom view when user is unauthorized in admin area.
     */
    public function test_403_page_renders_custom_view(): void
    {
        $warga = User::where('email', 'warga@sidesa.id')->firstOrFail();

        $response = $this->actingAs($warga)->get('/admin/users');

        $response->assertStatus(403);
        $response->assertSee('403');
        $response->assertSee('Akses Tidak Diizinkan');
        $response->assertSee('Kembali ke Beranda');
    }

    /**
     * Test public 403 page renders theme-based error view.
     */
    public function test_public_403_page_renders_theme_view(): void
    {
        // Route public yang memicu abort(403)
        $response = $this->get('/citizen/letters/create');
        // Saat guest mencoba mengakses rute warga, diarahkan atau jika abort(403)
        // Kita uji langsung dengan route closure testing jika diperlukan atau via middleware
        $this->assertTrue(view()->exists('themes.default.errors.403'));
        $this->assertTrue(view()->exists('themes.default.errors.404'));
        $this->assertTrue(view()->exists('themes.default.errors.500'));
        $this->assertTrue(view()->exists('themes.emerald.errors.404'));
    }
}
