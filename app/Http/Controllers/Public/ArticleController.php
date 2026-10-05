<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Tampilkan daftar kabar / berita desa untuk portal publik.
     */
    public function index(Request $request): View
    {
        $search = $request->input('q');
        $categorySlug = $request->input('kategori');

        $query = Content::posts()
            ->published()
            ->with(['author', 'categories'])
            ->orderByDesc('published_at');

        $currentCategory = null;
        if ($categorySlug) {
            $currentCategory = Category::where('slug', $categorySlug)->first();
            if ($currentCategory) {
                $query->whereHas('categories', function ($q) use ($currentCategory) {
                    $q->where('categories.id', $currentCategory->id);
                });
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(9)->withQueryString();

        $categories = Category::categories()
            ->withCount(['contents' => function ($q) {
                $q->posts()->published();
            }])
            ->having('contents_count', '>', 0)
            ->orderBy('name')
            ->get();

        $recentArticles = Content::posts()
            ->published()
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        return theme_view('articles.index', compact('articles', 'categories', 'currentCategory', 'search', 'recentArticles'));
    }

    /**
     * Tampilkan halaman detail artikel berita desa.
     */
    public function show(string $slug): View
    {
        $article = Content::posts()
            ->published()
            ->with(['author', 'categories'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Tingkatkan counter jumlah pembaca
        $article->increment('view_count');

        // Artikel terkait
        $categoryIds = $article->categories->pluck('id')->toArray();
        $relatedArticles = Content::posts()
            ->published()
            ->where('id', '!=', $article->id)
            ->when(! empty($categoryIds), function ($q) use ($categoryIds) {
                $q->whereHas('categories', function ($sq) use ($categoryIds) {
                    $sq->whereIn('categories.id', $categoryIds);
                });
            })
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $categories = Category::categories()
            ->withCount(['contents' => function ($q) {
                $q->posts()->published();
            }])
            ->having('contents_count', '>', 0)
            ->get();

        return theme_view('articles.show', compact('article', 'relatedArticles', 'categories'));
    }

    /**
     * Tampilkan artikel berdasarkan kategori tertentu.
     */
    public function category(string $slug): View
    {
        $currentCategory = Category::where('slug', $slug)->firstOrFail();

        $articles = Content::posts()
            ->published()
            ->with(['author', 'categories'])
            ->whereHas('categories', function ($q) use ($currentCategory) {
                $q->where('categories.id', $currentCategory->id);
            })
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::categories()
            ->withCount(['contents' => function ($q) {
                $q->posts()->published();
            }])
            ->having('contents_count', '>', 0)
            ->orderBy('name')
            ->get();

        $recentArticles = Content::posts()
            ->published()
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        $search = null;

        return theme_view('articles.index', compact('articles', 'categories', 'currentCategory', 'search', 'recentArticles'));
    }

    /**
     * Tampilkan daftar pengumuman resmi desa.
     */
    public function announcements(): View
    {
        $articles = Content::announcements()
            ->published()
            ->with(['author', 'categories'])
            ->orderByDesc('published_at')
            ->paginate(9);

        $categories = Category::categories()
            ->withCount(['contents' => function ($q) {
                $q->posts()->published();
            }])
            ->having('contents_count', '>', 0)
            ->orderBy('name')
            ->get();

        $currentCategory = Category::where('slug', 'pengumuman')->first();
        $search = null;
        $recentArticles = collect();

        return theme_view('articles.index', compact('articles', 'categories', 'currentCategory', 'search', 'recentArticles'));
    }
}
