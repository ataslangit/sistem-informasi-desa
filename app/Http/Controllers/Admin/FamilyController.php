<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Menampilkan daftar Kartu Keluarga.
     */
    public function index(Request $request): View
    {
        $keyword = $request->input('keyword');
        $hamlet = $request->input('hamlet');

        $families = Family::with(['headOfFamily', 'activeMembers'])
            ->search($keyword)
            ->byHamlet($hamlet)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $hamlets = Family::select('hamlet')->whereNotNull('hamlet')->distinct()->pluck('hamlet');

        return view('admin.families.index', compact('families', 'hamlets', 'keyword', 'hamlet'));
    }

    /**
     * Form tambah Kartu Keluarga baru.
     */
    public function create(): View
    {
        return view('admin.families.create');
    }

    /**
     * Menyimpan Kartu Keluarga baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'family_card_number' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:families,family_card_number'],
            'address' => ['nullable', 'string', 'max:500'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'hamlet' => ['nullable', 'string', 'max:50'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'social_assistance_status' => ['nullable', 'string', 'max:50'],
            'economic_status' => ['required', 'string', 'in:mampu,rentan,miskin,sangat_miskin'],
        ], [
            'family_card_number.required' => 'Nomor Kartu Keluarga wajib diisi.',
            'family_card_number.size' => 'Nomor Kartu Keluarga harus tepat 16 karakter angka.',
            'family_card_number.regex' => 'Nomor Kartu Keluarga hanya boleh berisi angka.',
            'family_card_number.unique' => 'Nomor Kartu Keluarga tersebut sudah terdaftar.',
            'rt.required' => 'Nomor RT wajib diisi.',
            'rw.required' => 'Nomor RW wajib diisi.',
        ]);

        $family = Family::create($validated);

        return redirect()->route('admin.families.show', $family)
            ->with('success', 'Kartu Keluarga baru berhasil didaftarkan. Anda dapat menambahkan anggota keluarga di bawah.');
    }

    /**
     * Menampilkan detail Kartu Keluarga beserta daftar anggotanya.
     */
    public function show(Family $family): View
    {
        $family->load(['headOfFamily', 'members' => function ($q) {
            $q->orderByRaw("CASE WHEN family_relationship_status = 'Kepala Keluarga' THEN 1 WHEN family_relationship_status = 'Istri' THEN 2 WHEN family_relationship_status = 'Anak' THEN 3 ELSE 4 END");
        }]);

        return view('admin.families.show', compact('family'));
    }

    /**
     * Form edit data Kartu Keluarga.
     */
    public function edit(Family $family): View
    {
        $family->load('members');

        return view('admin.families.edit', compact('family'));
    }

    /**
     * Memperbarui data Kartu Keluarga.
     */
    public function update(Request $request, Family $family): RedirectResponse
    {
        $validated = $request->validate([
            'family_card_number' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:families,family_card_number,'.$family->id],
            'head_of_family_id' => ['nullable', 'exists:residents,id'],
            'address' => ['nullable', 'string', 'max:500'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'hamlet' => ['nullable', 'string', 'max:50'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'social_assistance_status' => ['nullable', 'string', 'max:50'],
            'economic_status' => ['required', 'string', 'in:mampu,rentan,miskin,sangat_miskin'],
        ], [
            'family_card_number.required' => 'Nomor Kartu Keluarga wajib diisi.',
            'family_card_number.size' => 'Nomor Kartu Keluarga harus 16 digit angka.',
            'family_card_number.regex' => 'Nomor Kartu Keluarga harus angka.',
            'family_card_number.unique' => 'Nomor Kartu Keluarga tersebut sudah dipakai.',
        ]);

        $family->update($validated);

        return redirect()->route('admin.families.show', $family)
            ->with('success', 'Data Kartu Keluarga berhasil diperbarui.');
    }

    /**
     * Menghapus Kartu Keluarga (Soft Delete).
     */
    public function destroy(Family $family): RedirectResponse
    {
        // Lepaskan referensi family_id dari penduduk agar tidak orphaned
        $family->members()->update(['family_id' => null]);
        $family->delete();

        return redirect()->route('admin.families.index')
            ->with('success', 'Data Kartu Keluarga berhasil dihapus.');
    }
}
