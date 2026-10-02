<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman depan portal publik desa menggunakan tema aktif.
     */
    public function index(): View
    {
        return theme_view('home');
    }
}
