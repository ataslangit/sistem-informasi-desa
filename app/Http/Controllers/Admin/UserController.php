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

        return view('admin.users.create', compact('roles'));
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
            'phone' => ['nullable', 'string', 'max:25'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'is_active' => $request->boolean('is_active', true),
            'metadata' => array_filter([
                'phone' => $validated['phone'] ?? null,
                'jabatan' => $validated['jabatan'] ?? null,
            ]),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')
            ->with('success', "Akun pengguna {$user->name} berhasil ditambahkan.");
    }

    /**
     * Tampilkan formulir edit data pengguna.
     */
    public function edit(User $user): View
    {
        $user->load('roles');
        $roles = Role::orderBy('id')->get();

        return view('admin.users.edit', compact('user', 'roles'));
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
            'phone' => ['nullable', 'string', 'max:25'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $isSelf = $user->id === auth()->id();

        // Mencegah superadmin menonaktifkan akunnya sendiri
        $isActive = $isSelf ? true : $request->boolean('is_active', false);

        $updateData = [
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'is_active' => $isActive,
            'metadata' => array_filter([
                'phone' => $validated['phone'] ?? null,
                'jabatan' => $validated['jabatan'] ?? null,
            ]),
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

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
