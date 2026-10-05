<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Tampilkan daftar halaman statis desa.
     */
    public function index(Request $request): View
    {
        $status = $request->input('status');
        $keyword = $request->input('keyword');

        $query = Content::pages()
            ->with('author')
            ->orderBy('sort_order')
            ->orderByDesc('id');

        if ($status) {
            $query->where('status', $status);
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('summary', 'like', "%{$keyword}%")
                    ->orWhere('body', 'like', "%{$keyword}%");
            });
        }

        $pages = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => Content::pages()->count(),
            'published' => Content::pages()->where('status', Content::STATUS_PUBLISHED)->count(),
            'draft' => Content::pages()->where('status', Content::STATUS_DRAFT)->count(),
        ];

        return view('admin.pages.index', compact('pages', 'counts', 'status', 'keyword'));
    }

    /**
     * Form tambah halaman statis baru.
     */
    public function create(): View
    {
        return view('admin.pages.create');
    }

    /**
     * Simpan halaman statis baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:contents,slug'],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'cover_image' => ['nullable', 'url', 'max:500'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $meta = [
            'cover_image' => $validated['cover_image'] ?? null,
            'seo_title' => $validated['seo_title'] ?? null,
            'seo_description' => $validated['seo_description'] ?? null,
        ];

        $slug = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        $originalSlug = $slug;
        $counter = 1;
        while (Content::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $publishedAt = ($validated['status'] === Content::STATUS_PUBLISHED)
            ? Carbon::now()
            : null;

        Content::create([
            'tenant_type' => 'village',
            'tenant_id' => '1',
            'author_id' => $request->user()->id,
            'type' => Content::TYPE_PAGE,
            'title' => $validated['title'],
            'slug' => $slug,
            'summary' => $validated['summary'] ?? Str::limit(strip_tags($validated['body']), 200),
            'body' => $validated['body'],
            'meta' => $meta,
            'status' => $validated['status'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman statis berhasil ditambahkan.');
    }

    /**
     * Form edit halaman statis.
     */
    public function edit(Content $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update halaman statis.
     */
    public function update(Request $request, Content $page): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:contents,slug,'.$page->id],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'cover_image' => ['nullable', 'url', 'max:500'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $meta = $page->meta ?? [];
        $meta['cover_image'] = $validated['cover_image'] ?? null;
        $meta['seo_title'] = $validated['seo_title'] ?? null;
        $meta['seo_description'] = $validated['seo_description'] ?? null;

        $publishedAt = $page->published_at;
        if ($validated['status'] === Content::STATUS_PUBLISHED && ! $publishedAt) {
            $publishedAt = Carbon::now();
        } elseif ($validated['status'] === Content::STATUS_DRAFT) {
            $publishedAt = null;
        }

        $page->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'summary' => $validated['summary'] ?? Str::limit(strip_tags($validated['body']), 200),
            'body' => $validated['body'],
            'meta' => $meta,
            'status' => $validated['status'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman statis berhasil diperbarui.');
    }

    /**
     * Hapus halaman statis (Soft Delete).
     */
    public function destroy(Content $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman statis berhasil dihapus.');
    }
}
