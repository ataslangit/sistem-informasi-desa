<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Tampilkan daftar menu navigasi publik dan form manajemen.
     */
    public function index(): View
    {
        $menus = Menu::header()
            ->root()
            ->with(['children.page', 'page'])
            ->orderBy('sort_order')
            ->get();

        $staticPages = Content::pages()
            ->published()
            ->orderBy('title')
            ->get();

        $parentMenus = Menu::header()
            ->root()
            ->orderBy('name')
            ->get();

        return view('admin.menus.index', compact('menus', 'staticPages', 'parentMenus'));
    }

    /**
     * Simpan menu baru ke sistem.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:page,route,custom'],
            'page_id' => ['nullable', 'required_if:type,page', 'exists:contents,id'],
            'url' => ['nullable', 'required_unless:type,page', 'string', 'max:500'],
            'parent_id' => ['nullable', 'exists:menus,id'],
            'target' => ['required', 'in:_self,_blank'],
            'location' => ['required', 'in:header,footer'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $url = $validated['url'] ?? null;
        if ($validated['type'] === 'page' && ! empty($validated['page_id'])) {
            $page = Content::find($validated['page_id']);
            if ($page) {
                $url = '/halaman/'.$page->slug;
            }
        }

        Menu::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'page_id' => $validated['type'] === 'page' ? $validated['page_id'] : null,
            'url' => $url,
            'parent_id' => $validated['parent_id'] ?? null,
            'target' => $validated['target'],
            'location' => $validated['location'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.menus.index')
            ->with('success', "Menu '{$validated['name']}' berhasil ditambahkan.");
    }

    /**
     * Update menu navigasi.
     */
    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:page,route,custom'],
            'page_id' => ['nullable', 'required_if:type,page', 'exists:contents,id'],
            'url' => ['nullable', 'required_unless:type,page', 'string', 'max:500'],
            'parent_id' => ['nullable', 'exists:menus,id'],
            'target' => ['required', 'in:_self,_blank'],
            'location' => ['required', 'in:header,footer'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $url = $validated['url'] ?? null;
        if ($validated['type'] === 'page' && ! empty($validated['page_id'])) {
            $page = Content::find($validated['page_id']);
            if ($page) {
                $url = '/halaman/'.$page->slug;
            }
        }

        $menu->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'page_id' => $validated['type'] === 'page' ? $validated['page_id'] : null,
            'url' => $url,
            'parent_id' => $validated['parent_id'] ?? null,
            'target' => $validated['target'],
            'location' => $validated['location'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.menus.index')
            ->with('success', "Menu '{$menu->name}' berhasil diperbarui.");
    }

    /**
     * Hapus menu navigasi beserta submenunya.
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        $name = $menu->name;
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', "Menu '{$name}' berhasil dihapus.");
    }
}
