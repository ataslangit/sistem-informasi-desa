<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\User;
use App\Models\VillageBoundary;
use App\Models\VillageFacility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetAndGisIntegrationTest extends TestCase
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
     * Test public APBDes page renders data and chart attributes.
     */
    public function test_public_apbdes_page_is_accessible(): void
    {
        $response = $this->get('/apbdes');

        $response->assertStatus(200);
        $response->assertSee('Transparansi APBDes');
        $response->assertSee('Pendapatan Desa');
        $response->assertSee('Belanja Desa');
        $response->assertSee('Dana Desa (DDS - APBN)');
    }

    /**
     * Test public APBDes filter by year.
     */
    public function test_public_apbdes_filter_by_year(): void
    {
        $response = $this->get('/apbdes?year=2024');

        $response->assertStatus(200);
        $response->assertSee('Transparansi APBDes 2024');
    }

    /**
     * Test public Web GIS interactive map page.
     */
    public function test_public_web_gis_map_is_accessible(): void
    {
        $response = $this->get('/peta');

        $response->assertStatus(200);
        $response->assertSee('Peta Digital');
        $response->assertSee('Fasilitas Desa');
        $response->assertSee('Kantor Kepala Desa Sukamaju');
        $response->assertSee('villageMap');
    }

    /**
     * Test admin can view budget index and show detail.
     */
    public function test_admin_can_view_budgets_index_and_show(): void
    {
        $budget = Budget::where('year', 2024)->firstOrFail();

        $indexResponse = $this->actingAs($this->superadmin)->get('/admin/budgets');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Transparansi APBDes');
        $indexResponse->assertSee('Tahun 2024');

        $showResponse = $this->actingAs($this->superadmin)->get('/admin/budgets/'.$budget->id);
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Kelola Rincian: APBDes 2024');
    }

    /**
     * Test admin can create budget and manage its items.
     */
    public function test_admin_can_create_budget_and_manage_items(): void
    {
        // 1. Create 2025 budget
        $createResponse = $this->actingAs($this->superadmin)->post('/admin/budgets', [
            'year' => 2025,
            'title' => 'APBDes Tahun Anggaran 2025',
            'status' => 'published',
            'description' => 'Rencana APBDes tahun 2025.',
        ]);

        $this->assertDatabaseHas('budgets', [
            'year' => 2025,
            'title' => 'APBDes Tahun Anggaran 2025',
        ]);

        $budget = Budget::where('year', 2025)->firstOrFail();
        $createResponse->assertRedirect('/admin/budgets/'.$budget->id);

        // 2. Add budget item
        $addItemResponse = $this->actingAs($this->superadmin)->post('/admin/budgets/'.$budget->id.'/items', [
            'type' => 'revenue',
            'category' => 'Pendapatan BUMDes Berkah',
            'budgeted_amount' => 50000000,
            'realized_amount' => 52000000,
            'notes' => 'Hasil laba BUMDes',
        ]);

        $addItemResponse->assertRedirect('/admin/budgets/'.$budget->id);
        $this->assertDatabaseHas('budget_items', [
            'budget_id' => $budget->id,
            'category' => 'Pendapatan BUMDes Berkah',
            'budgeted_amount' => 50000000,
        ]);

        $item = $budget->items()->where('category', 'Pendapatan BUMDes Berkah')->firstOrFail();

        // 3. Update budget item
        $updateItemResponse = $this->actingAs($this->superadmin)->put('/admin/budgets/'.$budget->id.'/items/'.$item->id, [
            'category' => 'Pendapatan BUMDes Berkah (Revisi)',
            'budgeted_amount' => 60000000,
            'realized_amount' => 60000000,
        ]);

        $updateItemResponse->assertRedirect('/admin/budgets/'.$budget->id);
        $this->assertEquals('Pendapatan BUMDes Berkah (Revisi)', $item->fresh()->category);

        // 4. Delete budget item
        $deleteItemResponse = $this->actingAs($this->superadmin)->delete('/admin/budgets/'.$budget->id.'/items/'.$item->id);
        $deleteItemResponse->assertRedirect('/admin/budgets/'.$budget->id);
        $this->assertDatabaseMissing('budget_items', ['id' => $item->id]);

        // 5. Delete entire budget
        $deleteBudgetResponse = $this->actingAs($this->superadmin)->delete('/admin/budgets/'.$budget->id);
        $deleteBudgetResponse->assertRedirect('/admin/budgets');
        $this->assertDatabaseMissing('budgets', ['id' => $budget->id]);
    }

    /**
     * Test admin can manage geographic boundaries.
     */
    public function test_admin_can_manage_boundaries(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/boundaries');
        $response->assertStatus(200);
        $response->assertSee('Batas Wilayah Administratif Desa');

        // Create boundary
        $createResponse = $this->actingAs($this->superadmin)->post('/admin/boundaries', [
            'name' => 'Batas Dusun Baru RW 05',
            'type' => 'dusun',
            'color' => '#10b981',
            'area_hectares' => 50.5,
            'coordinates' => json_encode([
                [-6.910, 107.600],
                [-6.915, 107.605],
                [-6.918, 107.602],
                [-6.910, 107.600],
            ]),
        ]);

        $createResponse->assertRedirect('/admin/boundaries');
        $this->assertDatabaseHas('village_boundaries', [
            'name' => 'Batas Dusun Baru RW 05',
        ]);

        $boundary = VillageBoundary::where('name', 'Batas Dusun Baru RW 05')->firstOrFail();

        // Delete boundary
        $deleteResponse = $this->actingAs($this->superadmin)->delete('/admin/boundaries/'.$boundary->id);
        $deleteResponse->assertRedirect('/admin/boundaries');
        $this->assertDatabaseMissing('village_boundaries', ['id' => $boundary->id]);
    }

    /**
     * Test admin can manage public facilities.
     */
    public function test_admin_can_manage_facilities(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/facilities');
        $response->assertStatus(200);
        $response->assertSee('Fasilitas Umum');
        $response->assertSee('Infrastruktur Desa');

        // Create facility
        $createResponse = $this->actingAs($this->superadmin)->post('/admin/facilities', [
            'name' => 'Posyandu Mawar Indah RT 03',
            'category' => 'kesehatan',
            'latitude' => -6.915000,
            'longitude' => 107.611000,
            'address' => 'Jl. Mawar RT 03/01',
            'condition' => 'baik',
            'description' => 'Posyandu balita dan lansia',
        ]);

        $createResponse->assertRedirect('/admin/facilities');
        $this->assertDatabaseHas('village_facilities', [
            'name' => 'Posyandu Mawar Indah RT 03',
            'category' => 'kesehatan',
        ]);

        $facility = VillageFacility::where('name', 'Posyandu Mawar Indah RT 03')->firstOrFail();

        // Delete facility
        $deleteResponse = $this->actingAs($this->superadmin)->delete('/admin/facilities/'.$facility->id);
        $deleteResponse->assertRedirect('/admin/facilities');
        $this->assertDatabaseMissing('village_facilities', ['id' => $facility->id]);
    }

    /**
     * Test citizen cannot access admin budget & GIS routes.
     */
    public function test_citizen_cannot_access_admin_budget_and_gis_routes(): void
    {
        $bResponse = $this->actingAs($this->warga)->get('/admin/budgets');
        $bResponse->assertStatus(403);

        $boundResponse = $this->actingAs($this->warga)->get('/admin/boundaries');
        $boundResponse->assertStatus(403);

        $facResponse = $this->actingAs($this->warga)->get('/admin/facilities');
        $facResponse->assertStatus(403);
    }
}
