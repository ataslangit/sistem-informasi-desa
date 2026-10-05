<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetPermendagriComplianceTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();
    }

    /**
     * Test model Budget & BudgetItem menghitung 5 Bidang Belanja Baku Permendagri No. 20/2018.
     */
    public function test_budget_aggregates_5_standard_expenditure_fields(): void
    {
        $budget = Budget::where('year', 2024)->firstOrFail();

        $standardFields = $budget->expenditures_by_standard_fields;

        $this->assertCount(5, $standardFields);
        $this->assertArrayHasKey(BudgetItem::BIDANG_PEMERINTAHAN, $standardFields);
        $this->assertArrayHasKey(BudgetItem::BIDANG_PEMBANGUNAN, $standardFields);
        $this->assertArrayHasKey(BudgetItem::BIDANG_PEMBINAAN, $standardFields);
        $this->assertArrayHasKey(BudgetItem::BIDANG_PEMBERDAYAAN, $standardFields);
        $this->assertArrayHasKey(BudgetItem::BIDANG_BENCANA_DARURAT, $standardFields);

        $this->assertEquals('1', $standardFields[BudgetItem::BIDANG_PEMERINTAHAN]['code']);
        $this->assertEquals('2', $standardFields[BudgetItem::BIDANG_PEMBANGUNAN]['code']);
        $this->assertEquals('3', $standardFields[BudgetItem::BIDANG_PEMBINAAN]['code']);
        $this->assertEquals('4', $standardFields[BudgetItem::BIDANG_PEMBERDAYAAN]['code']);
        $this->assertEquals('5', $standardFields[BudgetItem::BIDANG_BENCANA_DARURAT]['code']);

        $this->assertGreaterThan(0, $standardFields[BudgetItem::BIDANG_PEMBANGUNAN]['realized']);
    }

    /**
     * Test restrukturisasi pos pembiayaan (Penerimaan SiLPA vs Pengeluaran BUMDes) dan perhitungan SiLPA berkenaan.
     */
    public function test_budget_financing_restructuring_and_silpa_calculation(): void
    {
        $budget = Budget::where('year', 2024)->firstOrFail();

        $this->assertNotEmpty($budget->financing_receipts);
        $this->assertNotEmpty($budget->financing_expenditures);

        $this->assertGreaterThan(0, $budget->total_realized_financing_receipt);
        $this->assertGreaterThan(0, $budget->total_realized_financing_expenditure);

        // Pembiayaan Netto = Penerimaan - Pengeluaran
        $expectedNet = $budget->total_realized_financing_receipt - $budget->total_realized_financing_expenditure;
        $this->assertEquals($expectedNet, $budget->net_financing_realized);

        // SiLPA = Surplus/Defisit + Pembiayaan Netto
        $expectedSilpa = $budget->surplus_deficit_realized + $budget->net_financing_realized;
        $this->assertEquals($expectedSilpa, $budget->silpa_realized);
    }

    /**
     * Test admin dapat menambah item dengan 5 bidang belanja baku dan pos pembiayaan.
     */
    public function test_admin_can_add_item_with_permendagri_fields_and_subtypes(): void
    {
        $budget = Budget::where('year', 2024)->firstOrFail();

        // 1. Tambah item belanja dengan Bidang Baku
        $resBelanja = $this->actingAs($this->superadmin)->post("/admin/budgets/{$budget->id}/items", [
            'type' => 'expenditure',
            'sub_type' => BudgetItem::BIDANG_PEMBANGUNAN,
            'code' => '5.2.1',
            'category' => 'Pembangunan Gorong-Gorong RT 03',
            'budgeted_amount' => 25000000,
            'realized_amount' => 24000000,
            'notes' => 'Dana Desa',
        ]);
        $resBelanja->assertRedirect("/admin/budgets/{$budget->id}");

        $this->assertDatabaseHas('budget_items', [
            'budget_id' => $budget->id,
            'type' => 'expenditure',
            'sub_type' => BudgetItem::BIDANG_PEMBANGUNAN,
            'code' => '5.2.1',
            'category' => 'Pembangunan Gorong-Gorong RT 03',
        ]);

        // 2. Tambah item pembiayaan pengeluaran untuk BUMDes
        $resFinancing = $this->actingAs($this->superadmin)->post("/admin/budgets/{$budget->id}/items", [
            'type' => 'financing',
            'sub_type' => BudgetItem::FINANCING_EXPENDITURE,
            'code' => '6.2.1',
            'category' => 'Penyertaan Modal BUMDes Unit Wisata',
            'budgeted_amount' => 50000000,
            'realized_amount' => 50000000,
            'notes' => 'Penyertaan Modal',
        ]);
        $resFinancing->assertRedirect("/admin/budgets/{$budget->id}");

        $this->assertDatabaseHas('budget_items', [
            'budget_id' => $budget->id,
            'type' => 'financing',
            'sub_type' => BudgetItem::FINANCING_EXPENDITURE,
            'code' => '6.2.1',
            'category' => 'Penyertaan Modal BUMDes Unit Wisata',
        ]);
    }

    /**
     * Test halaman publik APBDes menampilkan restrukturisasi pembiayaan dan 5 bidang belanja pada tema aktif.
     */
    public function test_public_apbdes_renders_permendagri_compliance(): void
    {
        Setting::set('active_theme', 'emerald');

        $response = $this->get('/apbdes');
        $response->assertStatus(200);
        $response->assertSee('Transparansi APBDes');
        $response->assertSee('Pembiayaan Neto');
        $response->assertSee('SiLPA Berkenaan');
        $response->assertSee('Komposisi 5 Bidang Belanja');
        $response->assertSee('Penerimaan Pembiayaan');
        $response->assertSee('Pengeluaran Pembiayaan');
    }

    /**
     * Test operasi create APBDes dan item anggaran tercatat ke dalam audit log.
     */
    public function test_budget_and_items_trigger_audit_trail(): void
    {
        $response = $this->actingAs($this->superadmin)->post('/admin/budgets', [
            'year' => 2026,
            'title' => 'APBDes Anggaran 2026',
            'status' => 'draft',
            'description' => 'Rancangan Anggaran 2026',
        ]);

        $createdBudget = Budget::where('year', 2026)->firstOrFail();
        $response->assertRedirect("/admin/budgets/{$createdBudget->id}");

        $this->assertDatabaseHas('audit_logs', [
            'event_name' => 'BudgetCreated',
            'entity_type' => 'budget',
            'entity_id' => (string) $createdBudget->id,
            'actor_id' => $this->superadmin->id,
        ]);

        $itemResponse = $this->actingAs($this->superadmin)->post("/admin/budgets/{$createdBudget->id}/items", [
            'type' => 'revenue',
            'category' => 'Pendapatan Asli Desa (PADes)',
            'budgeted_amount' => 150000000,
            'realized_amount' => 0,
        ]);

        $createdItem = BudgetItem::where('budget_id', $createdBudget->id)->firstOrFail();
        $itemResponse->assertRedirect("/admin/budgets/{$createdBudget->id}");

        $this->assertDatabaseHas('audit_logs', [
            'event_name' => 'BudgetItemCreated',
            'entity_type' => 'budgetitem',
            'entity_id' => (string) $createdItem->id,
            'actor_id' => $this->superadmin->id,
        ]);
    }
}
