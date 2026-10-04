<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PopulationStatisticService;
use Illuminate\Contracts\View\View;

class PopulationReportController extends Controller
{
    public function __construct(
        protected PopulationStatisticService $statisticService
    ) {}

    /**
     * Menampilkan laporan statistik & agregat kependudukan desa.
     */
    public function index(): View
    {
        $summary = $this->statisticService->getSummaryDashboard();
        $ageGroups = $this->statisticService->getAgeGroupDistribution();
        $educations = $this->statisticService->getEducationDistribution();
        $occupations = $this->statisticService->getOccupationDistribution();
        $hamlets = $this->statisticService->getHamletDistribution();
        $economicStatuses = $this->statisticService->getEconomicStatusDistribution();
        $religions = $this->statisticService->getReligionDistribution();

        return view('admin.reports.population', compact(
            'summary',
            'ageGroups',
            'educations',
            'occupations',
            'hamlets',
            'economicStatuses',
            'religions'
        ));
    }
}
