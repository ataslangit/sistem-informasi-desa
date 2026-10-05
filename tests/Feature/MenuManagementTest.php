<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Content;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuManagementTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected User $perangkat;

    protected User $warga;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();
        $this->perangkat = User::where('email', 'perangkat@sidesa.id')->firstOrFail();
        $this->warga = User::where('email', 'warga@sidesa.id')->firstOrFail();
    }

    /**
     * Test admin can access menu management page.
     */
    public function test_admin_can_view_menu_index(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/menus');

        $response->assertStatus(200);
        $response->assertSee('Manajemen Menu Navigasi Portal');
        $response->assertSee('Struktur Menu Header Portal');
        $response->assertSee('Profil Desa');
    }

    /**
     * Test admin can create a new menu linked to a static page.
     */
    public function test_admin_can_create_menu_linked_to_static_page(): void
    {
        $page = Content::pages()->where('slug', 'visi-misi')->firstOrFail();

        $response = $this->actingAs($this->perangkat)->post('/admin/menus', [
            'name' => 'Visi & Misi Desa',
            'type' => 'page',
            'page_id' => $page->id,
            'target' => '_self',
            'location' => 'header',
            'sort_order' => 10,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/menus');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('menus', [
            'name' => 'Visi & Misi Desa',
            'type' => 'page',
            'page_id' => $page->id,
            'url' => '/halaman/'.$page->slug,
            'sort_order' => 10,
        ]);
    }

    /**
     * Test admin can create submenu under an existing parent menu.
     */
    public function test_admin_can_create_submenu(): void
    {
        $parent = Menu::where('name', 'Profil Desa')->whereNull('parent_id')->firstOrFail();

        $response = $this->actingAs($this->superadmin)->post('/admin/menus', [
            'name' => 'Sejarah Dusun',
            'type' => 'custom',
            'url' => '/halaman/sejarah-dusun',
            'parent_id' => $parent->id,
            'target' => '_self',
            'location' => 'header',
            'sort_order' => 5,
        ]);

        $response->assertRedirect('/admin/menus');
        $this->assertDatabaseHas('menus', [
            'name' => 'Sejarah Dusun',
            'parent_id' => $parent->id,
            'url' => '/halaman/sejarah-dusun',
        ]);
    }

    /**
     * Test admin can update menu.
     */
    public function test_admin_can_update_menu(): void
    {
        $menu = Menu::where('name', 'Kabar Desa')->firstOrFail();

        $response = $this->actingAs($this->superadmin)->put('/admin/menus/'.$menu->id, [
            'name' => 'Warta Desa Terkini',
            'type' => 'route',
            'url' => '/berita',
            'target' => '_self',
            'location' => 'header',
            'sort_order' => 20,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/menus');
        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'name' => 'Warta Desa Terkini',
            'sort_order' => 20,
        ]);
    }

    /**
     * Test admin can delete menu and its children cascade.
     */
    public function test_admin_can_delete_menu(): void
    {
        $parent = Menu::where('name', 'Profil Desa')->firstOrFail();
        $childCount = $parent->children()->count();
        $this->assertGreaterThan(0, $childCount);

        $response = $this->actingAs($this->superadmin)->delete('/admin/menus/'.$parent->id);

        $response->assertRedirect('/admin/menus');
        $this->assertDatabaseMissing('menus', ['id' => $parent->id]);
        $this->assertDatabaseMissing('menus', ['parent_id' => $parent->id]);
    }

    /**
     * Test public home page renders dynamic menu structure.
     */
    public function test_public_home_renders_dynamic_menus(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Beranda');
        $response->assertSee('Profil Desa');
        $response->assertSee('Visi & Misi');
        $response->assertSee('Struktur Organisasi');
        $response->assertSee('Kabar Desa');
        $response->assertSee('Layanan Surat');
    }

    /**
     * Test citizen cannot access admin menu management.
     */
    public function test_citizen_cannot_access_menu_management(): void
    {
        $response = $this->actingAs($this->warga)->get('/admin/menus');
        $response->assertStatus(403);

        $postResponse = $this->actingAs($this->warga)->post('/admin/menus', [
            'name' => 'Menu Liar',
            'type' => 'custom',
            'url' => '/hacked',
            'target' => '_self',
            'location' => 'header',
        ]);
        $postResponse->assertStatus(403);
    }
}
