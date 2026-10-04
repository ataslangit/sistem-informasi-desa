<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PopulationStatisticService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected PopulationStatisticService $statisticService
    ) {}

    /**
     * Menampilkan halaman dashboard utama bagi staf/aparatur desa.
     */
    public function index(): View
    {
        $stats = $this->statisticService->getSummaryDashboard();

        return view('admin.dashboard.index', compact('stats'));
    }
}
