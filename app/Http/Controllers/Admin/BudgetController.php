<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\BudgetItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Tampilkan daftar tahun anggaran APBDes.
     */
    public function index(): View
    {
        $budgets = Budget::with('items')
            ->orderByDesc('year')
            ->paginate(10);

        return view('admin.budgets.index', compact('budgets'));
    }

    /**
     * Simpan tahun anggaran APBDes baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:2100', 'unique:budgets,year,NULL,id,tenant_type,village,tenant_id,1'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,archived'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $budget = Budget::create([
            'tenant_type' => 'village',
            'tenant_id' => '1',
            'year' => (int) $validated['year'],
            'title' => $validated['title'],
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.budgets.show', $budget)
            ->with('success', 'Tahun Anggaran APBDes berhasil dibuat. Silakan tambahkan rincian item anggaran.');
    }

    /**
     * Tampilkan dan kelola rincian item APBDes (Pendapatan, Belanja, Pembiayaan).
     */
    public function show(Budget $budget): View
    {
        $budget->load(['items' => fn ($q) => $q->orderBy('sort_order')->orderBy('id')]);
        $expenditureFields = BudgetItem::EXPENDITURE_FIELDS;
        $financingTypes = BudgetItem::FINANCING_TYPES;

        return view('admin.budgets.show', compact('budget', 'expenditureFields', 'financingTypes'));
    }

    /**
     * Perbarui informasi APBDes.
     */
    public function update(Request $request, Budget $budget): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,archived'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $budget->update($validated);

        return redirect()->route('admin.budgets.show', $budget)
            ->with('success', 'Informasi APBDes berhasil diperbarui.');
    }

    /**
     * Hapus tahun anggaran APBDes.
     */
    public function destroy(Budget $budget): RedirectResponse
    {
        $budget->delete();

        return redirect()->route('admin.budgets.index')
            ->with('success', 'Data APBDes berhasil dihapus.');
    }

    /**
     * Tambah item rincian anggaran.
     */
    public function storeItem(Request $request, Budget $budget): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:revenue,expenditure,financing'],
            'sub_type' => ['nullable', 'string', 'max:50'],
            'code' => ['nullable', 'string', 'max:50'],
            'category' => ['required', 'string', 'max:255'],
            'budgeted_amount' => ['required', 'numeric', 'min:0'],
            'realized_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $maxSort = (int) $budget->items()->where('type', $validated['type'])->max('sort_order');

        $budget->items()->create([
            'type' => $validated['type'],
            'sub_type' => $validated['sub_type'] ?? null,
            'code' => $validated['code'] ?? null,
            'category' => $validated['category'],
            'budgeted_amount' => (int) $validated['budgeted_amount'],
            'realized_amount' => (int) ($validated['realized_amount'] ?? 0),
            'notes' => $validated['notes'] ?? null,
            'sort_order' => $maxSort + 1,
        ]);

        return redirect()->route('admin.budgets.show', $budget)
            ->with('success', 'Item anggaran berhasil ditambahkan.');
    }

    /**
     * Perbarui item rincian anggaran.
     */
    public function updateItem(Request $request, Budget $budget, BudgetItem $item): RedirectResponse
    {
        abort_if($item->budget_id !== $budget->id, 404);

        $validated = $request->validate([
            'sub_type' => ['nullable', 'string', 'max:50'],
            'code' => ['nullable', 'string', 'max:50'],
            'category' => ['required', 'string', 'max:255'],
            'budgeted_amount' => ['required', 'numeric', 'min:0'],
            'realized_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $item->update([
            'sub_type' => $validated['sub_type'] ?? $item->sub_type,
            'code' => $validated['code'] ?? $item->code,
            'category' => $validated['category'],
            'budgeted_amount' => (int) $validated['budgeted_amount'],
            'realized_amount' => (int) ($validated['realized_amount'] ?? 0),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.budgets.show', $budget)
            ->with('success', 'Item anggaran berhasil diperbarui.');
    }

    /**
     * Hapus item rincian anggaran.
     */
    public function destroyItem(Budget $budget, BudgetItem $item): RedirectResponse
    {
        abort_if($item->budget_id !== $budget->id, 404);

        $item->delete();

        return redirect()->route('admin.budgets.show', $budget)
            ->with('success', 'Item anggaran berhasil dihapus.');
    }
}
