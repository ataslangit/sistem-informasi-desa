<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\GalleryPhoto;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Tampilkan daftar album galeri foto dokumentasi desa.
     */
    public function index(Request $request): View
    {
        $keyword = $request->input('keyword');

        $query = Content::galleries()
            ->withCount('photos')
            ->with('author')
            ->orderByDesc('id');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('summary', 'like', "%{$keyword}%");
            });
        }

        $galleries = $query->paginate(12)->withQueryString();

        return view('admin.galleries.index', compact('galleries', 'keyword'));
    }

    /**
     * Simpan album galeri baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image_url' => ['required', 'url', 'max:500'],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Content::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $gallery = Content::create([
            'tenant_type' => 'village',
            'tenant_id' => '1',
            'author_id' => $request->user()->id,
            'type' => Content::TYPE_GALLERY,
            'title' => $validated['title'],
            'slug' => $slug,
            'summary' => $validated['summary'] ?? $validated['title'],
            'body' => $validated['body'] ?? $validated['title'],
            'meta' => [
                'cover_image' => $validated['image_url'],
            ],
            'status' => Content::STATUS_PUBLISHED,
            'published_at' => Carbon::now(),
        ]);

        // Simpan foto cover sebagai foto pertama di dalam album
        $gallery->photos()->create([
            'image_url' => $validated['image_url'],
            'caption' => $validated['title'],
            'sort_order' => 1,
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Album galeri foto berhasil dibuat.');
    }

    /**
     * Tampilkan detail album dan kelola foto-foto di dalamnya.
     */
    public function show(Content $gallery): View
    {
        abort_if($gallery->type !== Content::TYPE_GALLERY, 404);

        $gallery->load(['author', 'photos' => fn ($q) => $q->orderBy('sort_order')->orderBy('id')]);

        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Tambahkan foto ke dalam album galeri.
     */
    public function storePhoto(Request $request, Content $gallery): RedirectResponse
    {
        abort_if($gallery->type !== Content::TYPE_GALLERY, 404);

        $validated = $request->validate([
            'image_url' => ['required', 'url', 'max:500'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        $maxSort = (int) $gallery->photos()->max('sort_order');

        $photo = $gallery->photos()->create([
            'image_url' => $validated['image_url'],
            'caption' => $validated['caption'] ?? $gallery->title,
            'sort_order' => $maxSort + 1,
        ]);

        // Set cover image jika belum ada
        $meta = $gallery->meta ?? [];
        if (empty($meta['cover_image'])) {
            $meta['cover_image'] = $photo->image_url;
            $gallery->update(['meta' => $meta]);
        }

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Foto baru berhasil ditambahkan ke dalam album.');
    }

    /**
     * Hapus satu foto dari album galeri.
     */
    public function destroyPhoto(Content $gallery, GalleryPhoto $photo): RedirectResponse
    {
        abort_if($photo->gallery_id !== $gallery->id, 404);

        $photo->delete();

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Foto berhasil dihapus dari album.');
    }

    /**
     * Hapus album galeri dan foto di dalamnya.
     */
    public function destroy(Content $gallery): RedirectResponse
    {
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Album galeri berhasil dihapus.');
    }
}
