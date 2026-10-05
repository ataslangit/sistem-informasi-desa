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
        $kibType = $request->input('kib_type');
        $ownershipStatus = $request->input('ownership_status');
        $isVillageAsset = $request->input('is_village_asset');

        $query = VillageFacility::query();

        if ($category) {
            $query->where('category', $category);
        }

        if ($kibType) {
            $query->where('kib_type', $kibType);
        }

        if ($ownershipStatus) {
            $query->where('ownership_status', $ownershipStatus);
        }

        if ($isVillageAsset !== null && $isVillageAsset !== '') {
            $query->where('is_village_asset', (bool) $isVillageAsset);
        }

        $facilities = $query->latest()->paginate(12)->withQueryString();
        $categories = VillageFacility::getCategories();
        $kibMetas = VillageFacility::getKibMetas();
        $ownershipStatuses = VillageFacility::getOwnershipStatuses();

        $editId = $request->input('edit');
        $editingFacility = $editId ? VillageFacility::find($editId) : null;

        return view('admin.map.facilities.index', compact(
            'facilities',
            'categories',
            'category',
            'kibMetas',
            'ownershipStatuses',
            'kibType',
            'ownershipStatus',
            'isVillageAsset',
            'editingFacility'
        ));
    }

    /**
     * Simpan fasilitas / titik aset baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $currentYear = (int) date('Y');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:pemerintahan,kesehatan,pendidikan,ibadah,ekonomi,wisata,infrastruktur'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'address' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'condition' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'description' => ['nullable', 'string', 'max:500'],

            // Permendagri No. 1/2016 Atribut Yuridis Aset Desa
            'is_village_asset' => ['nullable', 'boolean'],
            'kib_type' => ['nullable', 'in:kib_a,kib_b,kib_c,kib_d,kib_e,kib_f'],
            'ownership_status' => ['nullable', 'in:tanah_kas_desa,apbdes,hibah,pemerintah_pusat,pemerintah_daerah,lainnya_sah'],
            'register_code' => ['nullable', 'string', 'max:100'],
            'surface_area' => ['nullable', 'numeric', 'min:0'],
            'acquisition_year' => ['nullable', 'integer', 'min:1900', 'max:'.($currentYear + 1)],
            'asset_value' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['is_village_asset'] = $request->boolean('is_village_asset');

        VillageFacility::create($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Titik fasilitas / aset desa berhasil ditambahkan.');
    }

    /**
     * Perbarui data fasilitas / titik aset.
     */
    public function update(Request $request, VillageFacility $facility): RedirectResponse
    {
        $currentYear = (int) date('Y');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:pemerintahan,kesehatan,pendidikan,ibadah,ekonomi,wisata,infrastruktur'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'address' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'condition' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'description' => ['nullable', 'string', 'max:500'],

            // Permendagri No. 1/2016 Atribut Yuridis Aset Desa
            'is_village_asset' => ['nullable', 'boolean'],
            'kib_type' => ['nullable', 'in:kib_a,kib_b,kib_c,kib_d,kib_e,kib_f'],
            'ownership_status' => ['nullable', 'in:tanah_kas_desa,apbdes,hibah,pemerintah_pusat,pemerintah_daerah,lainnya_sah'],
            'register_code' => ['nullable', 'string', 'max:100'],
            'surface_area' => ['nullable', 'numeric', 'min:0'],
            'acquisition_year' => ['nullable', 'integer', 'min:1900', 'max:'.($currentYear + 1)],
            'asset_value' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['is_village_asset'] = $request->boolean('is_village_asset');

        $facility->update($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Data fasilitas / aset desa berhasil diperbarui.');
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
