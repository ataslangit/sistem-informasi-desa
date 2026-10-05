<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Contracts\View\View;

class GalleryController extends Controller
{
    /**
     * Tampilkan daftar album galeri foto desa untuk publik.
     */
    public function index(): View
    {
        $galleries = Content::galleries()
            ->published()
            ->withCount('photos')
            ->with(['author', 'photos'])
            ->orderByDesc('published_at')
            ->paginate(12);

        return theme_view('galleries.index', compact('galleries'));
    }

    /**
     * Tampilkan detail album galeri foto beserta kumpulan foto di dalamnya.
     */
    public function show(string $slug): View
    {
        $gallery = Content::galleries()
            ->published()
            ->with(['author', 'photos' => fn ($q) => $q->orderBy('sort_order')->orderBy('id')])
            ->where('slug', $slug)
            ->firstOrFail();

        $gallery->increment('view_count');

        $recentGalleries = Content::galleries()
            ->published()
            ->where('id', '!=', $gallery->id)
            ->withCount('photos')
            ->latest('published_at')
            ->take(4)
            ->get();

        return theme_view('galleries.show', compact('gallery', 'recentGalleries'));
    }
}
