<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Ttpryg\ContentEngine\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    /**
     * Tampilkan daftar kategori dan tag CMS.
     */
    public function index(Request $request): View
    {
        $type = $request->input('type');

        $query = Category::withCount('contents')
            ->orderBy('type')
            ->orderBy('name');

        if ($type && in_array($type, ['category', 'tag'], true)) {
            $query->where('type', $type);
        }

        $categories = $query->paginate(20)->withQueryString();

        $counts = [
            'all' => Category::count(),
            'categories' => Category::categories()->count(),
            'tags' => Category::tags()->count(),
        ];

        return view('admin.categories.index', compact('categories', 'counts', 'type'));
    }

    /**
     * Simpan kategori/tag baru menggunakan CategoryService.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:category,tag'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
        ]);

        $slug = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);

        // Pastikan slug unik
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $this->categoryService->createCategory(
            name: $validated['name'],
            type: $validated['type'],
            slug: $slug
        );

        $label = $validated['type'] === 'tag' ? 'Tag' : 'Kategori';

        return redirect()->route('admin.categories.index')
            ->with('success', "{$label} '{$validated['name']}' berhasil ditambahkan.");
    }

    /**
     * Update data kategori/tag.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:category,tag'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,'.$category->id],
        ]);

        $category->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'slug' => Str::slug($validated['slug']),
        ]);

        $label = $validated['type'] === 'tag' ? 'Tag' : 'Kategori';

        return redirect()->route('admin.categories.index')
            ->with('success', "{$label} '{$category->name}' berhasil diperbarui.");
    }

    /**
     * Hapus kategori/tag.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $name = $category->name;
        $label = $category->type === 'tag' ? 'Tag' : 'Kategori';

        // Lepas relasi pivot sebelum dihapus
        $category->contents()->detach();
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', "{$label} '{$name}' berhasil dihapus.");
    }
}
