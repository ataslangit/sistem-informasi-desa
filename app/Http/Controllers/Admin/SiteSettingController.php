<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Formulir pengaturan profil situs, identitas desa, kontak, dan metadata portal publik.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        if (! $user->hasRole(['superadmin', 'kades']) && ! $user->hasPermission('settings.manage')) {
            abort(403, 'Anda tidak memiliki hak otorisasi untuk mengakses pengaturan situs.');
        }

        $settings = [
            // Identitas & Wilayah Desa
            'village_name' => (string) Setting::get('village_name', 'Desa Sukamaju'),
            'village_code' => (string) Setting::get('village_code', '3201012001'),
            'subdistrict_name' => (string) (Setting::get('subdistrict_name') ?: Setting::get('district_name', 'Kecamatan Cibinong')),
            'district_name' => (string) (Setting::get('regency_name') ?: Setting::get('district_name', 'Kabupaten Bogor')),
            'province_name' => (string) Setting::get('province_name', 'Jawa Barat'),
            'postal_code' => (string) Setting::get('postal_code', '16911'),
            'village_head_name' => (string) Setting::get('village_head_name', 'H. Mulyadi, S.Sos.'),
            'timezone' => (string) Setting::get('timezone', config('app.timezone', 'Asia/Jakarta')),

            // Kontak & Lokasi Kantor Desa
            'village_address' => (string) Setting::get('village_address', 'Jl. Raya Desa Sukamaju No. 01'),
            'village_phone' => (string) Setting::get('village_phone', '021-87654321'),
            'village_email' => (string) Setting::get('village_email', 'kantor@sukamaju.desa.id'),
            'office_hours' => (string) Setting::get('office_hours', 'Senin - Kamis: 08.00 - 15.00 WIB, Jumat: 08.00 - 11.30 WIB'),

            // Metadata & SEO Portal Publik
            'app_title' => (string) Setting::get('app_title', 'SiDesa - Portal Resmi Desa Sukamaju'),
            'app_tagline' => (string) Setting::get('app_tagline', 'Mewujudkan Desa Maju, Mandiri, dan Transparan Berbasis Digital'),
            'meta_description' => (string) Setting::get('meta_description', 'Portal resmi Sistem Informasi Desa Sukamaju menyajikan transparansi publik, administrasi persuratan mandiri, dan publikasi kabar desa terkini.'),
            'meta_keywords' => (string) Setting::get('meta_keywords', 'desa sukamaju, sistem informasi desa, sid, ppid desa, apbdes, surat desa'),

            // Media Sosial & Branding
            'facebook_url' => (string) Setting::get('facebook_url', 'https://facebook.com/'),
            'instagram_url' => (string) Setting::get('instagram_url', 'https://instagram.com/'),
            'youtube_url' => (string) Setting::get('youtube_url', 'https://youtube.com/'),
            'twitter_url' => (string) Setting::get('twitter_url', 'https://twitter.com/'),
            'village_logo' => (string) Setting::get('village_logo', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Memperbarui konfigurasi situs web dan profil desa.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! $user->hasRole(['superadmin', 'kades']) && ! $user->hasPermission('settings.manage')) {
            abort(403, 'Anda tidak memiliki hak otorisasi untuk mengubah pengaturan situs.');
        }

        $validated = $request->validate([
            // Identitas Desa
            'village_name' => ['required', 'string', 'max:255'],
            'village_code' => ['nullable', 'string', 'max:50'],
            'subdistrict_name' => ['required', 'string', 'max:255'],
            'district_name' => ['required', 'string', 'max:255'],
            'province_name' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'village_head_name' => ['nullable', 'string', 'max:255'],
            'timezone' => ['required', 'string', 'in:Asia/Jakarta,Asia/Makassar,Asia/Jayapura'],

            // Kontak & Lokasi Kantor
            'village_address' => ['required', 'string', 'max:500'],
            'village_phone' => ['required', 'string', 'max:50'],
            'village_email' => ['required', 'email', 'max:255'],
            'office_hours' => ['nullable', 'string', 'max:255'],

            // Metadata & SEO Portal Publik
            'app_title' => ['required', 'string', 'max:255'],
            'app_tagline' => ['required', 'string', 'max:500'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],

            // Media Sosial
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],

            // Logo
            'village_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:2048'],
        ]);

        // Unggah berkas logo baru jika ada
        if ($request->hasFile('village_logo')) {
            $logoPath = $request->file('village_logo')->store('settings', 'public');
            Setting::set('village_logo', '/storage/'.$logoPath, 'village', 'Logo Resmi Pemerintah Desa');
        }
        unset($validated['village_logo']);

        // Pemetaan kategori grup setting
        $groupMapping = [
            'village_name' => ['village', 'Nama Resmi Desa'],
            'village_code' => ['village', 'Kode Wilayah Kemendagri Desa'],
            'subdistrict_name' => ['village', 'Nama Kecamatan'],
            'district_name' => ['village', 'Nama Kabupaten / Kota'],
            'province_name' => ['village', 'Nama Provinsi'],
            'postal_code' => ['village', 'Kode Pos Kantor Desa'],
            'village_head_name' => ['village', 'Nama Kepala Desa'],
            'timezone' => ['general', 'Zona Waktu Wilayah Desa (WIB/WITA/WIT)'],
            'village_address' => ['village', 'Alamat Lengkap Kantor Desa'],
            'village_phone' => ['village', 'Telepon / WhatsApp Resmi Desa'],
            'village_email' => ['village', 'Email Resmi Kantor Desa'],
            'office_hours' => ['village', 'Jam Pelayanan Kantor Desa'],
            'app_title' => ['general', 'Judul Web Portal Desa'],
            'app_tagline' => ['general', 'Slogan / Tagline Resmi Desa'],
            'meta_description' => ['seo', 'Deskripsi SEO Web Portal'],
            'meta_keywords' => ['seo', 'Kata Kunci SEO Web Portal'],
            'facebook_url' => ['social', 'Tautan Halaman Facebook Desa'],
            'instagram_url' => ['social', 'Tautan Akun Instagram Desa'],
            'youtube_url' => ['social', 'Tautan Kanal YouTube Desa'],
            'twitter_url' => ['social', 'Tautan Akun Twitter / X Desa'],
        ];

        foreach ($validated as $key => $value) {
            $group = $groupMapping[$key][0] ?? 'general';
            $description = $groupMapping[$key][1] ?? $key;
            Setting::set($key, (string) ($value ?? ''), $group, $description);
        }

        // Terapkan langsung zona waktu aktif pada proses saat ini
        if (isset($validated['timezone'])) {
            date_default_timezone_set($validated['timezone']);
            config(['app.timezone' => $validated['timezone']]);
        }

        // Sinkronisasi ganda untuk konsistensi pembacaan kabupaten / kota
        if (isset($validated['district_name'])) {
            Setting::set('regency_name', (string) $validated['district_name'], 'village', 'Nama Kabupaten / Kota (Regency)');
        }

        return back()->with('success', 'Pengaturan situs dan profil desa berhasil diperbarui.');
    }
}
