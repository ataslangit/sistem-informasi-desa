<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ttpryg\ContentEngine\Services\ContentService;

class ArticleController extends Controller
{
    public function __construct(
        protected ContentService $contentService
    ) {}

    /**
     * Tampilkan daftar artikel berita desa.
     */
    public function index(Request $request): View
    {
        $status = $request->input('status');
        $categoryId = $request->input('category_id');
        $keyword = $request->input('keyword');

        $query = Content::posts()
            ->with(['author', 'categories'])
            ->orderByDesc('id');

        if ($status) {
            $query->where('status', $status);
        }

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('summary', 'like', "%{$keyword}%")
                    ->orWhere('body', 'like', "%{$keyword}%");
            });
        }

        $articles = $query->paginate(15)->withQueryString();
        $categories = Category::categories()->orderBy('name')->get();

        $counts = [
            'all' => Content::posts()->count(),
            'published' => Content::posts()->where('status', Content::STATUS_PUBLISHED)->count(),
            'draft' => Content::posts()->where('status', Content::STATUS_DRAFT)->count(),
            'archived' => Content::posts()->where('status', Content::STATUS_ARCHIVED)->count(),
        ];

        return view('admin.articles.index', compact('articles', 'categories', 'counts', 'status', 'categoryId', 'keyword'));
    }

    /**
     * Form tulis artikel berita baru.
     */
    public function create(): View
    {
        $categories = Category::categories()->orderBy('name')->get();

        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Simpan artikel berita baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            'cover_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
        ]);

        $coverImage = $validated['cover_image'] ?? null;
        if ($request->hasFile('cover_image_file')) {
            $path = $request->file('cover_image_file')->store('articles', 'public');
            $coverImage = '/storage/'.$path;
        }

        $meta = [
            'cover_image' => $coverImage,
            'seo_title' => $validated['seo_title'] ?? null,
            'seo_description' => $validated['seo_description'] ?? null,
        ];

        $publishedAt = null;
        if ($validated['status'] === Content::STATUS_PUBLISHED) {
            $publishedAt = ! empty($validated['published_at'])
                ? Carbon::parse($validated['published_at'])
                : Carbon::now();
        }

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Content::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $article = Content::create([
            'tenant_type' => 'village',
            'tenant_id' => '1',
            'author_id' => $request->user()->id,
            'type' => Content::TYPE_POST,
            'title' => $validated['title'],
            'slug' => $slug,
            'summary' => $validated['summary'] ?? Str::limit(strip_tags($validated['body']), 200),
            'body' => $validated['body'],
            'meta' => $meta,
            'status' => $validated['status'],
            'published_at' => $publishedAt,
        ]);

        if (! empty($validated['categories'])) {
            $article->categories()->sync($validated['categories']);
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berita berhasil disimpan.');
    }

    /**
     * Form edit artikel berita.
     */
    public function edit(Content $article): View
    {
        $categories = Category::categories()->orderBy('name')->get();
        $selectedCategories = $article->categories->pluck('id')->toArray();

        return view('admin.articles.edit', compact('article', 'categories', 'selectedCategories'));
    }

    /**
     * Update artikel berita.
     */
    public function update(Request $request, Content $article): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:contents,slug,'.$article->id],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            'cover_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
        ]);

        $meta = $article->meta ?? [];

        if ($request->hasFile('cover_image_file')) {
            $oldCover = $meta['cover_image'] ?? null;
            if ($oldCover && str_starts_with($oldCover, '/storage/articles/')) {
                $oldPath = str_replace('/storage/', '', $oldCover);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('cover_image_file')->store('articles', 'public');
            $meta['cover_image'] = '/storage/'.$path;
        } elseif (array_key_exists('cover_image', $validated)) {
            $meta['cover_image'] = $validated['cover_image'];
        }

        $meta['seo_title'] = $validated['seo_title'] ?? null;
        $meta['seo_description'] = $validated['seo_description'] ?? null;

        $publishedAt = $article->published_at;
        if ($validated['status'] === Content::STATUS_PUBLISHED && ! $publishedAt) {
            $publishedAt = ! empty($validated['published_at'])
                ? Carbon::parse($validated['published_at'])
                : Carbon::now();
        } elseif ($validated['status'] === Content::STATUS_DRAFT) {
            $publishedAt = null;
        }

        $article->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'summary' => $validated['summary'] ?? Str::limit(strip_tags($validated['body']), 200),
            'body' => $validated['body'],
            'meta' => $meta,
            'status' => $validated['status'],
            'published_at' => $publishedAt,
        ]);

        $article->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berita berhasil diperbarui.');
    }

    /**
     * Hapus artikel berita (Soft Delete).
     */
    public function destroy(Content $article): RedirectResponse
    {
        $meta = $article->meta ?? [];
        $cover = $meta['cover_image'] ?? null;
        if ($cover && str_starts_with($cover, '/storage/articles/')) {
            $path = str_replace('/storage/', '', $cover);
            Storage::disk('public')->delete($path);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berita berhasil dihapus.');
    }
}
