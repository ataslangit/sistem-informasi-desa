<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Identitas Desa
            ['key' => 'village_name', 'value' => 'Desa Sukamaju', 'group' => 'village', 'description' => 'Nama Resmi Desa'],
            ['key' => 'village_code', 'value' => '3201012001', 'group' => 'village', 'description' => 'Kode Wilayah Kemendagri Desa'],
            ['key' => 'subdistrict_name', 'value' => 'Kecamatan Makmur', 'group' => 'village', 'description' => 'Nama Kecamatan'],
            ['key' => 'district_name', 'value' => 'Kabupaten Nusantara', 'group' => 'village', 'description' => 'Nama Kabupaten / Kota'],
            ['key' => 'province_name', 'value' => 'Jawa Barat', 'group' => 'village', 'description' => 'Nama Provinsi'],
            ['key' => 'postal_code', 'value' => '40123', 'group' => 'village', 'description' => 'Kode Pos Kantor Desa'],
            ['key' => 'village_address', 'value' => 'Jl. Raya Desa Sukamaju No. 01', 'group' => 'village', 'description' => 'Alamat Kantor Desa'],
            ['key' => 'village_phone', 'value' => '021-88889999', 'group' => 'village', 'description' => 'Telepon / WhatsApp Kantor Desa'],
            ['key' => 'village_email', 'value' => 'kantor@sukamaju.desa.id', 'group' => 'village', 'description' => 'Email Resmi Kantor Desa'],

            // Sistem & Tampilan Tema
            ['key' => 'active_theme', 'value' => 'default', 'group' => 'theme', 'description' => 'Tema Publik Aktif (resources/views/themes/{tema})'],
            ['key' => 'app_title', 'value' => 'SiDesa - Portal Resmi Desa Sukamaju', 'group' => 'general', 'description' => 'Judul Halaman Web Portal Publik'],
            ['key' => 'app_tagline', 'value' => 'Mewujudkan Desa Maju, Mandiri, dan Transparan Berbasis Digital', 'group' => 'general', 'description' => 'Slogan / Tagline Desa'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                    'description' => $setting['description'],
                ]
            );
        }
    }
}
