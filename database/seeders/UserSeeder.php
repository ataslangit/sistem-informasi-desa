<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Super Administrator
        $superadmin = User::updateOrCreate(
            ['email' => 'admin@sidesa.id'],
            [
                'name' => 'Super Administrator',
                'username' => 'superadmin',
                'password' => Hash::make('password'),
                'is_active' => true,
                'metadata' => [
                    'phone' => '081234567890',
                    'jabatan' => 'Sistem Administrator IT',
                ],
            ]
        );
        $superadmin->assignRole('superadmin');

        // 2. Akun Kepala Desa
        $kades = User::updateOrCreate(
            ['email' => 'kades@sidesa.id'],
            [
                'name' => 'H. Mulyadi, S.Sos.',
                'username' => 'kades',
                'password' => Hash::make('password'),
                'is_active' => true,
                'metadata' => [
                    'nip' => '197508152005011002',
                    'jabatan' => 'Kepala Desa Sukamaju',
                ],
            ]
        );
        $kades->assignRole('kades');

        // 3. Akun Perangkat Desa / Kasi Pelayanan
        $perangkat = User::updateOrCreate(
            ['email' => 'perangkat@sidesa.id'],
            [
                'name' => 'Ahmad Fauzi',
                'username' => 'perangkat',
                'password' => Hash::make('password'),
                'is_active' => true,
                'metadata' => [
                    'jabatan' => 'Kasi Pelayanan Umum',
                ],
            ]
        );
        $perangkat->assignRole('perangkat');

        // 4. Akun Contoh Warga
        $warga = User::updateOrCreate(
            ['email' => 'warga@sidesa.id'],
            [
                'name' => 'Budi Santoso',
                'username' => 'warga',
                'password' => Hash::make('password'),
                'is_active' => true,
                'metadata' => [
                    'nik' => '3201011508900001',
                    'no_kk' => '3201011202150001',
                    'rt' => '001',
                    'rw' => '002',
                ],
            ]
        );
        $warga->assignRole('warga');
    }
}
