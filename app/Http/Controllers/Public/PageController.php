<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    /**
     * Tampilkan halaman statis publik (Profil Desa, Visi Misi, dsb).
     */
    public function show(string $slug): View
    {
        $page = Content::pages()
            ->published()
            ->with('author')
            ->where('slug', $slug)
            ->firstOrFail();

        $page->increment('view_count');

        // Navigasi halaman statis lainnya
        $otherPages = Content::pages()
            ->published()
            ->where('id', '!=', $page->id)
            ->orderBy('sort_order')
            ->get();

        return theme_view('pages.show', compact('page', 'otherPages'));
    }
}
