<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageFacility;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VillageFacilityController extends Controller
{
    /**
     * Tampilkan daftar fasilitas umum dan sarana infrastruktur desa.
     */
    public function index(Request $request): View
    {
        $category = $request->input('category');
        $query = VillageFacility::query();

        if ($category) {
            $query->where('category', $category);
        }

        $facilities = $query->latest()->paginate(12)->withQueryString();
        $categories = VillageFacility::getCategories();

        return view('admin.map.facilities.index', compact('facilities', 'categories', 'category'));
    }

    /**
     * Simpan fasilitas baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:pemerintahan,kesehatan,pendidikan,ibadah,ekonomi,wisata,infrastruktur'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'address' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'condition' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        VillageFacility::create($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Titik fasilitas umum berhasil ditambahkan.');
    }

    /**
     * Perbarui data fasilitas.
     */
    public function update(Request $request, VillageFacility $facility): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:pemerintahan,kesehatan,pendidikan,ibadah,ekonomi,wisata,infrastruktur'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'address' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'condition' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $facility->update($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Data fasilitas umum berhasil diperbarui.');
    }

    /**
     * Hapus fasilitas.
     */
    public function destroy(VillageFacility $facility): RedirectResponse
    {
        $facility->delete();

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas umum berhasil dihapus.');
    }
}
