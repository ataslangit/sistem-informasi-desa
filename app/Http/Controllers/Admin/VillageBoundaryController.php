<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageBoundary;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VillageBoundaryController extends Controller
{
    /**
     * Tampilkan daftar wilayah batas desa & dusun.
     */
    public function index(): View
    {
        $boundaries = VillageBoundary::latest()->paginate(10);

        return view('admin.map.boundaries.index', compact('boundaries'));
    }

    /**
     * Simpan batas wilayah baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:village,dusun,rw,rt'],
            'color' => ['required', 'string', 'max:20'],
            'area_hectares' => ['nullable', 'numeric', 'min:0'],
            'coordinates' => ['required', 'string'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $coords = json_decode($validated['coordinates'], true);
        if (! is_array($coords) || count($coords) < 3) {
            return back()->withInput()->withErrors(['coordinates' => 'Format koordinat poligon harus berupa array JSON valid minimal 3 titik koordinat.']);
        }

        VillageBoundary::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'color' => $validated['color'],
            'area_hectares' => isset($validated['area_hectares']) ? (float) $validated['area_hectares'] : null,
            'coordinates' => $coords,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.boundaries.index')
            ->with('success', 'Batas wilayah administratif berhasil ditambahkan.');
    }

    /**
     * Perbarui batas wilayah.
     */
    public function update(Request $request, VillageBoundary $boundary): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:village,dusun,rw,rt'],
            'color' => ['required', 'string', 'max:20'],
            'area_hectares' => ['nullable', 'numeric', 'min:0'],
            'coordinates' => ['required', 'string'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $coords = json_decode($validated['coordinates'], true);
        if (! is_array($coords) || count($coords) < 3) {
            return back()->withInput()->withErrors(['coordinates' => 'Format koordinat poligon harus berupa array JSON valid minimal 3 titik koordinat.']);
        }

        $boundary->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'color' => $validated['color'],
            'area_hectares' => isset($validated['area_hectares']) ? (float) $validated['area_hectares'] : null,
            'coordinates' => $coords,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.boundaries.index')
            ->with('success', 'Batas wilayah berhasil diperbarui.');
    }

    /**
     * Hapus batas wilayah.
     */
    public function destroy(VillageBoundary $boundary): RedirectResponse
    {
        $boundary->delete();

        return redirect()->route('admin.boundaries.index')
            ->with('success', 'Batas wilayah berhasil dihapus.');
    }
}
