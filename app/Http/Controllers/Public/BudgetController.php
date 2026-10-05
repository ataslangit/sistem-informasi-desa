<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Tampilkan transparansi APBDes desa untuk publik.
     */
    public function index(Request $request): View
    {
        $budgets = Budget::published()
            ->with('items')
            ->orderByDesc('year')
            ->get();

        $selectedYear = (int) $request->input('year', $budgets->first()?->year ?? (int) date('Y'));

        $budget = $budgets->firstWhere('year', $selectedYear);

        $chartData = [
            'overview' => [
                'labels' => ['Pendapatan Desa', 'Belanja Desa'],
                'budgeted' => [
                    $budget?->total_budgeted_revenue ?? 0,
                    $budget?->total_budgeted_expenditure ?? 0,
                ],
                'realized' => [
                    $budget?->total_realized_revenue ?? 0,
                    $budget?->total_realized_expenditure ?? 0,
                ],
            ],
            'expenditures' => [
                'labels' => $budget?->expenditures->pluck('category')->toArray() ?? [],
                'values' => $budget?->expenditures->pluck('realized_amount')->toArray() ?? [],
            ],
            'revenues' => [
                'labels' => $budget?->revenues->pluck('category')->toArray() ?? [],
                'values' => $budget?->revenues->pluck('realized_amount')->toArray() ?? [],
            ],
        ];

        return theme_view('budgets.index', compact('budgets', 'budget', 'selectedYear', 'chartData'));
    }
}
