<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomErrorPagesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Test 404 page renders custom village branded view.
     */
    public function test_404_page_renders_custom_view(): void
    {
        $response = $this->get('/url-yang-tidak-pernah-ada-12345');

        $response->assertStatus(404);
        $response->assertSee('404');
        $response->assertSee('Halaman Tidak Ditemukan');
        $response->assertSee('Kembali ke Beranda');
        $response->assertSee('Dokumen Publik (DIP)');
    }

    /**
     * Test 403 page renders custom view when user is unauthorized.
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
}
