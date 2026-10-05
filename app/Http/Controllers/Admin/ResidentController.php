<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResidentController extends Controller
{
    /**
     * Menampilkan daftar Buku Induk Penduduk.
     */
    public function index(Request $request): View
    {
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $status = $request->input('status', 'active');

        $residents = Resident::with('family')
            ->search($keyword)
            ->gender($gender)
            ->status($status)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.residents.index', compact('residents', 'keyword', 'gender', 'status'));
    }

    /**
     * Form tambah penduduk baru.
     */
    public function create(Request $request): View
    {
        $families = Family::select('id', 'family_card_number', 'address', 'rt', 'rw')->get();
        $selectedFamilyId = $request->input('family_id');

        return view('admin.residents.create', compact('families', 'selectedFamilyId'));
    }

    /**
     * Menyimpan data penduduk baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:residents,nik'],
            'family_id' => ['nullable', 'exists:families,id'],
            'name' => ['required', 'string', 'max:255'],
            'birth_place' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', 'in:L,P'],
            'blood_type' => ['nullable', 'string', 'max:5'],
            'religion' => ['required', 'string', 'max:30'],
            'marital_status' => ['required', 'string', 'max:30'],
            'family_relationship_status' => ['required', 'string', 'max:50'],
            'education_level' => ['required', 'string', 'max:50'],
            'occupation' => ['required', 'string', 'max:100'],
            'nationality' => ['required', 'string', 'max:10'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,moved,deceased,temporary'],
        ], [
            'nik.required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.',
            'nik.size' => 'NIK harus tepat 16 karakter angka.',
            'nik.regex' => 'NIK hanya boleh berisi digit angka.',
            'nik.unique' => 'NIK tersebut telah terdaftar dalam sistem.',
            'name.required' => 'Nama lengkap penduduk wajib diisi.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        $resident = Resident::create($validated);

        // Jika penduduk berstatus Kepala Keluarga dan memiliki KK, otomatis set head_of_family_id pada KK
        if ($resident->family_id && $resident->family_relationship_status === 'Kepala Keluarga') {
            Family::where('id', $resident->family_id)->update(['head_of_family_id' => $resident->id]);
        }

        if ($request->has('from_family') && $resident->family_id) {
            return redirect()->route('admin.families.show', $resident->family_id)
                ->with('success', 'Anggota keluarga baru berhasil ditambahkan.');
        }

        return redirect()->route('admin.residents.show', $resident)
            ->with('success', 'Data penduduk baru berhasil disimpan ke Buku Induk.');
    }

    /**
     * Menampilkan biodata detail penduduk beserta histori mutasi.
     */
    /**
     * Detail biodata penduduk lengkap.
     */
    public function show(Resident $resident): View
    {
        $resident->load(['family.headOfFamily', 'mutations.creator', 'user.roles']);

        return view('admin.residents.show', compact('resident'));
    }

    /**
     * Buatkan akun layanan mandiri untuk penduduk yang bersangkutan.
     */
    public function createAccount(Request $request, Resident $resident): RedirectResponse
    {
        if ($resident->user_id || User::where('username', $resident->nik)->exists()) {
            return back()->with('error', 'Penduduk ini sudah memiliki akun layanan mandiri terdaftar.');
        }

        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.required' => 'Email wajib diisi untuk akun warga.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.required' => 'Kata sandi akun wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $user = User::create([
            'name' => $resident->name,
            'username' => $resident->nik, // Default username menggunakan NIK 16 digit
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'is_active' => true,
            'metadata' => array_filter([
                'nik' => $resident->nik,
                'no_kk' => $resident->family?->family_card_number,
                'rt' => $resident->family?->rt,
                'rw' => $resident->family?->rw,
            ]),
        ]);

        $user->assignRole('warga');
        $resident->update(['user_id' => $user->id]);

        return redirect()->route('admin.residents.show', $resident)
            ->with('success', "Akun Layanan Mandiri berhasil dibuat! Username: {$user->username}");
    }

    /**
     * Form edit biodata penduduk.
     */
    public function edit(Resident $resident): View
    {
        $families = Family::select('id', 'family_card_number', 'address', 'rt', 'rw')->get();

        return view('admin.residents.edit', compact('resident', 'families'));
    }

    /**
     * Memperbarui data biodata penduduk.
     */
    public function update(Request $request, Resident $resident): RedirectResponse
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:residents,nik,'.$resident->id],
            'family_id' => ['nullable', 'exists:families,id'],
            'name' => ['required', 'string', 'max:255'],
            'birth_place' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', 'in:L,P'],
            'blood_type' => ['nullable', 'string', 'max:5'],
            'religion' => ['required', 'string', 'max:30'],
            'marital_status' => ['required', 'string', 'max:30'],
            'family_relationship_status' => ['required', 'string', 'max:50'],
            'education_level' => ['required', 'string', 'max:50'],
            'occupation' => ['required', 'string', 'max:100'],
            'nationality' => ['required', 'string', 'max:10'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,moved,deceased,temporary'],
        ], [
            'nik.required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.',
            'nik.size' => 'NIK harus tepat 16 karakter angka.',
            'nik.regex' => 'NIK hanya boleh berupa angka.',
            'nik.unique' => 'NIK tersebut sudah digunakan penduduk lain.',
        ]);

        $resident->update($validated);

        // Jika status kepala keluarga diupdate
        if ($resident->family_id && $resident->family_relationship_status === 'Kepala Keluarga') {
            Family::where('id', $resident->family_id)->update(['head_of_family_id' => $resident->id]);
        }

        return redirect()->route('admin.residents.show', $resident)
            ->with('success', 'Biodata penduduk berhasil diperbarui.');
    }

    /**
     * Menghapus penduduk (Soft Delete).
     */
    public function destroy(Resident $resident): RedirectResponse
    {
        // Cek jika penduduk adalah kepala keluarga di KK-nya
        if ($resident->family && (int) $resident->family->head_of_family_id === (int) $resident->id) {
            $resident->family->update(['head_of_family_id' => null]);
        }

        $resident->delete();

        return redirect()->route('admin.residents.index')
            ->with('success', 'Data penduduk berhasil dihapus dari sistem.');
    }
}
