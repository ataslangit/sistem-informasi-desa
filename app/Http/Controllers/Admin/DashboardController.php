<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama bagi staf/aparatur desa.
     */
    public function index(): View
    {
        return view('admin.dashboard.index');
    }
}
