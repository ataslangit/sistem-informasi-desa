<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Tampilkan daftar akun pengguna dengan filter dan pencarian.
     */
    public function index(Request $request): View
    {
        $keyword = $request->input('keyword');
        $roleFilter = $request->input('role');
        $statusFilter = $request->input('status');

        $query = User::with('roles')
            ->search($keyword)
            ->role($roleFilter)
            ->status($statusFilter);

        $users = $query->latest()->paginate(15)->withQueryString();

        // Statistik ringkasan akun pengguna
        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'superadmin' => User::role('superadmin')->count(),
            'kades' => User::role('kades')->count(),
            'perangkat' => User::role('perangkat')->count(),
            'rt' => User::role('rt')->count(),
            'warga' => User::role('warga')->count(),
        ];

        $roles = Role::orderBy('id')->get();

        return view('admin.users.index', compact('users', 'roles', 'keyword', 'roleFilter', 'statusFilter', 'stats'));
    }

    /**
     * Tampilkan formulir pembuatan pengguna baru.
     */
    public function create(): View
    {
        $roles = Role::orderBy('id')->get();
        $residents = \App\Models\Resident::whereNull('user_id')->orderBy('name')->get();

        return view('admin.users.create', compact('roles', 'residents'));
    }

    /**
     * Simpan data pengguna baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'nik' => ['nullable', 'string', 'size:16', 'regex:/^[0-9]{16}$/'],
            'resident_id' => ['nullable', 'exists:residents,id'],
            'rt' => ['nullable', 'string', 'max:5'],
            'rw' => ['nullable', 'string', 'max:5'],
            'phone' => ['nullable', 'string', 'max:25'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'nik.size' => 'NIK harus tepat 16 digit angka.',
            'nik.regex' => 'Format NIK hanya boleh berisi 16 digit angka.',
        ]);

        // Validasi khusus: Role 'warga' wajib terdaftar NIK-nya di database penduduk desa
        $resident = null;
        if ($validated['role'] === 'warga') {
            if (! empty($validated['resident_id'])) {
                $resident = \App\Models\Resident::find($validated['resident_id']);
            } elseif (! empty($validated['nik'])) {
                $resident = \App\Models\Resident::where('nik', $validated['nik'])->first();
            }

            if (! $resident) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'resident_id' => 'Akun peran warga wajib ditautkan dengan data penduduk desa (NIK) yang terdaftar di Buku Induk Penduduk.',
                ]);
            }

            if ($resident->user_id) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'resident_id' => 'Penduduk atas nama '.$resident->name.' (NIK: '.$resident->nik.') sudah memiliki akun pengguna aktif.',
                ]);
            }
        }

        $nikToSave = $resident?->nik ?? $validated['nik'] ?? null;
        $rtToSave = $validated['rt'] ?? ($resident?->family?->rt ?? null);
        $rwToSave = $validated['rw'] ?? ($resident?->family?->rw ?? null);

        $metadata = array_filter([
            'nik' => $nikToSave,
            'rt' => $rtToSave,
            'rw' => $rwToSave,
            'phone' => $validated['phone'] ?? null,
            'jabatan' => $validated['jabatan'] ?? null,
        ]);

        $user = User::create([
            'name' => $resident ? $resident->name : $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'is_active' => $request->boolean('is_active', true),
            'metadata' => ! empty($metadata) ? $metadata : null,
        ]);

        $user->assignRole($validated['role']);

        if ($resident) {
            $resident->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', "Akun pengguna {$user->name} berhasil ditambahkan.");
    }

    /**
     * Tampilkan formulir edit data pengguna.
     */
    public function edit(User $user): View
    {
        $user->load(['roles', 'resident']);
        $roles = Role::orderBy('id')->get();
        $residents = \App\Models\Resident::whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->orderBy('name')
            ->get();

        return view('admin.users.edit', compact('user', 'roles', 'residents'));
    }

    /**
     * Perbarui data pengguna yang ada.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'max:50', 'unique:users,username,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', Password::min(8), 'confirmed'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'nik' => ['nullable', 'string', 'size:16', 'regex:/^[0-9]{16}$/'],
            'resident_id' => ['nullable', 'exists:residents,id'],
            'rt' => ['nullable', 'string', 'max:5'],
            'rw' => ['nullable', 'string', 'max:5'],
            'phone' => ['nullable', 'string', 'max:25'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'nik.size' => 'NIK harus tepat 16 digit angka.',
            'nik.regex' => 'Format NIK hanya boleh berisi 16 digit angka.',
        ]);

        $isSelf = $user->id === auth()->id();

        // Mencegah superadmin menonaktifkan akunnya sendiri
        $isActive = $isSelf ? true : $request->boolean('is_active', false);

        // Penanganan khusus untuk role 'warga'
        $resident = null;
        if ($validated['role'] === 'warga') {
            if (! empty($validated['resident_id'])) {
                $resident = \App\Models\Resident::find($validated['resident_id']);
            } elseif (! empty($validated['nik'])) {
                $resident = \App\Models\Resident::where('nik', $validated['nik'])->first();
            } else {
                $resident = $user->resident;
            }

            if (! $resident) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'resident_id' => 'Akun peran warga wajib ditautkan dengan data penduduk desa (NIK) yang terdaftar di Buku Induk Penduduk.',
                ]);
            }

            if ($resident->user_id && $resident->user_id !== $user->id) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'resident_id' => 'Penduduk atas nama '.$resident->name.' sudah memiliki akun pengguna lain.',
                ]);
            }
        }

        $nikToSave = $resident?->nik ?? ($request->has('nik') ? $validated['nik'] : ($user->metadata['nik'] ?? null));
        $rtToSave = $validated['rt'] ?? ($resident?->family?->rt ?? ($request->has('rt') ? null : ($user->metadata['rt'] ?? null)));
        $rwToSave = $validated['rw'] ?? ($resident?->family?->rw ?? ($request->has('rw') ? null : ($user->metadata['rw'] ?? null)));

        $metadata = $user->metadata ?? [];

        if (! empty($nikToSave)) {
            $metadata['nik'] = $nikToSave;
        } else {
            unset($metadata['nik']);
        }

        if (! empty($rtToSave)) {
            $metadata['rt'] = $rtToSave;
        } else {
            unset($metadata['rt']);
        }

        if (! empty($rwToSave)) {
            $metadata['rw'] = $rwToSave;
        } else {
            unset($metadata['rw']);
        }

        if (! empty($validated['phone'])) {
            $metadata['phone'] = $validated['phone'];
        } else {
            unset($metadata['phone']);
        }

        if (! empty($validated['jabatan'])) {
            $metadata['jabatan'] = $validated['jabatan'];
        } else {
            unset($metadata['jabatan']);
        }

        $updateData = [
            'name' => $resident ? $resident->name : $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'is_active' => $isActive,
            'metadata' => ! empty($metadata) ? $metadata : null,
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        // Sinkronisasi relasi resident
        if ($resident && $resident->user_id !== $user->id) {
            // Lepas resident lama jika ganti
            if ($user->resident && $user->resident->id !== $resident->id) {
                $user->resident->update(['user_id' => null]);
            }
            $resident->update(['user_id' => $user->id]);
        } elseif ($validated['role'] !== 'warga' && $user->resident) {
            // Jika role diubah dari warga ke non-warga, biarkan atau lepaskan relasi
        }

        // Mencegah superadmin mencabut role superadmin dari akunnya sendiri jika tidak ada superadmin lain
        if ($isSelf && $user->hasRole('superadmin') && $validated['role'] !== 'superadmin') {
            $superadminCount = User::role('superadmin')->where('id', '!=', $user->id)->count();
            if ($superadminCount === 0) {
                return redirect()->route('admin.users.index')
                    ->with('warning', 'Data akun diperbarui, namun role Superadmin tidak dapat diubah karena Anda adalah satu-satunya Superadmin aktif.');
            }
        }

        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')
            ->with('success', "Data akun {$user->name} berhasil diperbarui.");
    }

    /**
     * Beralih status aktif / nonaktif akun pengguna.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        $statusLabel = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->name} berhasil {$statusLabel}.");
    }

    /**
     * Hapus akun pengguna (Soft Delete).
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->hasRole('superadmin')) {
            $superadminCount = User::role('superadmin')->where('id', '!=', $user->id)->count();
            if ($superadminCount === 0) {
                return back()->with('error', 'Tidak dapat menghapus satu-satunya akun Super Administrator.');
            }
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun pengguna {$userName} berhasil dihapus.");
    }
}
