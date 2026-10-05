<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Data Role
        $roles = [
            'superadmin' => [
                'label' => 'Super Administrator',
                'description' => 'Akses penuh ke seluruh konfigurasi sistem, database, dan hak akses.',
            ],
            'kades' => [
                'label' => 'Kepala Desa',
                'description' => 'Monitoring statistik desa, persetujuan dan TTE surat pelayanan warga.',
            ],
            'perangkat' => [
                'label' => 'Perangkat Desa',
                'description' => 'Operator pelayanan administrasi, pengelolaan buku induk kependudukan, dan verifikasi berkas.',
            ],
            'rt' => [
                'label' => 'Ketua RT',
                'description' => 'Verifikasi awal permohonan surat warga tingkat rukun tetangga.',
            ],
            'warga' => [
                'label' => 'Warga',
                'description' => 'Masyarakat desa yang memiliki akun untuk permohonan surat layanan mandiri.',
            ],
        ];

        $roleModels = [];
        foreach ($roles as $name => $meta) {
            $roleModels[$name] = Role::firstOrCreate(
                ['name' => $name],
                [
                    'label' => $meta['label'],
                    'description' => $meta['description'],
                ]
            );
        }

        // 2. Data Permission
        $permissions = [
            'admin.access' => ['label' => 'Akses Dashboard Admin', 'desc' => 'Dapat mengakses area back-office /admin'],
            'users.manage' => ['label' => 'Kelola Pengguna', 'desc' => 'Manajemen data akun, role, dan hak akses pengguna'],
            'settings.manage' => ['label' => 'Kelola Pengaturan', 'desc' => 'Ubah profil desa, tema publik, dan parameter sistem'],
            'residents.view' => ['label' => 'Lihat Kependudukan', 'desc' => 'Melihat data penduduk dan kartu keluarga'],
            'residents.manage' => ['label' => 'Kelola Kependudukan', 'desc' => 'Tambah, edit, hapus, dan mutasi data penduduk'],
            'letters.request' => ['label' => 'Pengajuan Surat', 'desc' => 'Mengajukan permohonan surat layanan mandiri'],
            'letters.verify_rt' => ['label' => 'Verifikasi Surat RT', 'desc' => 'Verifikasi pengantar surat tingkat RT'],
            'letters.process' => ['label' => 'Proses Surat Desa', 'desc' => 'Verifikasi berkas dan pengesahan staf desa'],
            'letters.approve' => ['label' => 'Persetujuan & TTE Surat', 'desc' => 'Tanda tangan elektronik / persetujuan kades'],
            'letters.manage_templates' => ['label' => 'Kelola Template Surat', 'desc' => 'Konfigurasi format dan template surat desa'],
            'reports.view' => ['label' => 'Lihat Laporan', 'desc' => 'Melihat laporan statistik dan agregat'],
        ];

        $permModels = [];
        foreach ($permissions as $name => $meta) {
            $permModels[$name] = Permission::firstOrCreate(
                ['name' => $name],
                [
                    'label' => $meta['label'],
                    'description' => $meta['desc'],
                ]
            );
        }

        // 3. Menghubungkan Role dengan Permissions
        // Superadmin: Semua permission
        $roleModels['superadmin']->permissions()->sync(collect($permModels)->pluck('id'));

        // Kades: Admin access, lihat penduduk, approve surat, lihat laporan
        $roleModels['kades']->permissions()->sync([
            $permModels['admin.access']->id,
            $permModels['residents.view']->id,
            $permModels['letters.approve']->id,
            $permModels['reports.view']->id,
        ]);

        // Perangkat: Admin access, lihat & kelola penduduk, proses surat, kelola template, lihat laporan
        $roleModels['perangkat']->permissions()->sync([
            $permModels['admin.access']->id,
            $permModels['residents.view']->id,
            $permModels['residents.manage']->id,
            $permModels['letters.process']->id,
            $permModels['letters.manage_templates']->id,
            $permModels['reports.view']->id,
        ]);

        // RT: Admin access (terbatas), lihat penduduk, verifikasi surat RT
        $roleModels['rt']->permissions()->sync([
            $permModels['admin.access']->id,
            $permModels['residents.view']->id,
            $permModels['letters.verify_rt']->id,
        ]);

        // Warga: Pengajuan surat mandiri
        $roleModels['warga']->permissions()->sync([
            $permModels['letters.request']->id,
        ]);
    }
}
