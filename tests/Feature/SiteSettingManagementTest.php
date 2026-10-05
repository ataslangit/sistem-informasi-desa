<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteSettingManagementTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected User $kades;

    protected User $warga;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();
        $this->kades = User::where('email', 'kades@sidesa.id')->firstOrFail();
        $this->warga = User::where('email', 'warga@sidesa.id')->firstOrFail();
    }

    /**
     * Test superadmin dapat mengakses halaman pengaturan situs.
     */
    public function test_superadmin_can_access_site_settings_page(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/settings');

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Situs &amp; Profil Desa', false);
        $response->assertSee('Nama Resmi Desa');
        $response->assertSee('Pemerintahan &amp; Batas Administrasi Wilayah', false);
        $response->assertSee('Desa Sukamaju');
    }

    /**
     * Test kepala desa dapat mengakses halaman pengaturan situs.
     */
    public function test_kades_can_access_site_settings_page(): void
    {
        $response = $this->actingAs($this->kades)->get('/admin/settings');

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Situs &amp; Profil Desa', false);
    }

    /**
     * Test pengguna non-admin (warga) dilarang mengakses halaman pengaturan situs.
     */
    public function test_non_authorized_user_cannot_access_site_settings(): void
    {
        $response = $this->actingAs($this->warga)->get('/admin/settings');

        // Warga tidak memiliki peran admin/perangkat dan dicegat middleware admin / abort 403
        $this->assertTrue(in_array($response->status(), [302, 403]));
    }

    /**
     * Test superadmin dapat memperbarui seluruh konfigurasi situs dan profil desa.
     */
    public function test_superadmin_can_update_site_settings(): void
    {
        $updatePayload = [
            'village_name' => 'Desa Sukamaju Mandiri',
            'village_code' => '3201012099',
            'subdistrict_name' => 'Kecamatan Cibinong Sejahtera',
            'district_name' => 'Kabupaten Bogor Raya',
            'province_name' => 'Jawa Barat',
            'postal_code' => '16915',
            'village_head_name' => 'H. Mulyadi Saputra, S.Sos.',
            'village_address' => 'Jl. Pahlawan Kemerdekaan No. 45 RT 02/RW 03',
            'village_phone' => '021-99887766',
            'village_email' => 'sekretariat@sukamaju.desa.id',
            'office_hours' => 'Senin - Jumat: 08.00 - 16.00 WIB',
            'app_title' => 'SiDesa - Portal Resmi Sukamaju Mandiri',
            'app_tagline' => 'Bersama Membangun Desa Mandiri, Cerdas, dan Berbudaya',
            'meta_description' => 'Website resmi desa Sukamaju Mandiri untuk transparansi publik dan administrasi.',
            'meta_keywords' => 'desa mandiri, sukamaju, cibinong, bogor, sid',
            'facebook_url' => 'https://facebook.com/sukamajumandiri',
            'instagram_url' => 'https://instagram.com/sukamajumandiri',
            'youtube_url' => 'https://youtube.com/@sukamajumandiri',
            'twitter_url' => 'https://twitter.com/sukamajumandiri',
        ];

        $response = $this->actingAs($this->superadmin)->post('/admin/settings', $updatePayload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Verifikasi perubahan tersimpan pada model Setting
        $this->assertEquals('Desa Sukamaju Mandiri', Setting::get('village_name'));
        $this->assertEquals('3201012099', Setting::get('village_code'));
        $this->assertEquals('Kecamatan Cibinong Sejahtera', Setting::get('subdistrict_name'));
        $this->assertEquals('Kabupaten Bogor Raya', Setting::get('district_name'));
        $this->assertEquals('Kabupaten Bogor Raya', Setting::get('regency_name'));
        $this->assertEquals('H. Mulyadi Saputra, S.Sos.', Setting::get('village_head_name'));
        $this->assertEquals('sekretariat@sukamaju.desa.id', Setting::get('village_email'));
        $this->assertEquals('SiDesa - Portal Resmi Sukamaju Mandiri', Setting::get('app_title'));
        $this->assertEquals('https://instagram.com/sukamajumandiri', Setting::get('instagram_url'));
    }

    /**
     * Test validasi gagal jika kolom wajib dikosongkan.
     */
    public function test_site_setting_validation_fails_on_invalid_data(): void
    {
        $response = $this->actingAs($this->superadmin)->post('/admin/settings', [
            'village_name' => '', // Wajib
            'subdistrict_name' => '', // Wajib
            'district_name' => '', // Wajib
            'village_email' => 'bukan-email-valid', // Format email
            'app_title' => '', // Wajib
        ]);

        $response->assertSessionHasErrors([
            'village_name',
            'subdistrict_name',
            'district_name',
            'village_email',
            'app_title',
        ]);
    }
}
