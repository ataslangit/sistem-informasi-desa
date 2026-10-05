<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\VillageBoundary;
use App\Models\VillageFacility;
use Illuminate\Contracts\View\View;

class MapController extends Controller
{
    /**
     * Tampilkan peta interaktif Web GIS desa untuk publik.
     */
    public function index(): View
    {
        $boundaries = VillageBoundary::all();
        $facilities = VillageFacility::all();
        $categories = VillageFacility::getCategories();
        $kibMetas = VillageFacility::getKibMetas();
        $ownershipStatuses = VillageFacility::getOwnershipStatuses();

        return theme_view('map.index', compact('boundaries', 'facilities', 'categories', 'kibMetas', 'ownershipStatuses'));
    }
}
