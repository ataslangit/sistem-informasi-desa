<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Tampilkan daftar role dan matriks hak akses sistem.
     */
    public function index(): View
    {
        $roles = Role::with(['permissions'])->withCount('users')->orderBy('id')->get();
        $permissions = Permission::orderBy('name')->get();

        // Mengelompokkan permission berdasarkan kategori prefix (misal: 'residents', 'letters', dll)
        $groupedPermissions = $permissions->groupBy(function (Permission $perm): string {
            $parts = explode('.', $perm->name);

            return match ($parts[0]) {
                'admin' => 'Akses Inti Sistem',
                'users' => 'Manajemen Pengguna & Role',
                'settings' => 'Konfigurasi & Pengaturan',
                'residents' => 'Buku Induk Kependudukan',
                'letters' => 'Layanan Persuratan Desa',
                'contents' => 'CMS Berita & Konten Publik',
                'reports' => 'Laporan & Statistik',
                default => 'Lainnya',
            };
        });

        return view('admin.roles.index', compact('roles', 'permissions', 'groupedPermissions'));
    }

    /**
     * Tampilkan detail role dan hak aksesnya.
     */
    public function show(Role $role): View
    {
        $role->load(['permissions', 'users']);
        $permissions = Permission::orderBy('name')->get();

        $groupedPermissions = $permissions->groupBy(function (Permission $perm): string {
            $parts = explode('.', $perm->name);

            return match ($parts[0]) {
                'admin' => 'Akses Inti Sistem',
                'users' => 'Manajemen Pengguna & Role',
                'settings' => 'Konfigurasi & Pengaturan',
                'residents' => 'Buku Induk Kependudukan',
                'letters' => 'Layanan Persuratan Desa',
                'contents' => 'CMS Berita & Konten Publik',
                'reports' => 'Laporan & Statistik',
                default => 'Lainnya',
            };
        });

        return view('admin.roles.show', compact('role', 'groupedPermissions'));
    }

    /**
     * Perbarui daftar hak akses (permissions) yang dimiliki role.
     */
    public function updatePermissions(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $permissionIds = $validated['permissions'] ?? [];

        // Proteksi Superadmin agar hak akses krusial tidak terhapus
        if ($role->name === 'superadmin') {
            $essentialPerms = Permission::whereIn('name', ['admin.access', 'users.manage', 'settings.manage'])->pluck('id')->toArray();
            $permissionIds = array_unique(array_merge($permissionIds, $essentialPerms));
        }

        $role->permissions()->sync($permissionIds);

        return redirect()->route('admin.roles.index')
            ->with('success', "Hak akses untuk role {$role->label} berhasil diperbarui.");
    }
}
