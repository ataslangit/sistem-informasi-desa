<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman depan portal publik desa menggunakan tema aktif.
     */
    public function index(): View
    {
        $latestArticles = Content::posts()
            ->published()
            ->with(['author', 'categories'])
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $featuredPages = Content::pages()
            ->published()
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return theme_view('home', compact('latestArticles', 'featuredPages'));
    }
}
