<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Services\WilayahService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WilayahApiIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $superadmin;

    protected User $warga;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('email', 'admin@sidesa.id')->firstOrFail();
        $this->warga = User::where('email', 'warga@sidesa.id')->firstOrFail();
        Cache::flush();
    }

    /**
     * Test WilayahService mengambil data provinsi dan menyimpannya di cache.
     */
    public function test_wilayah_service_fetches_and_caches_provinces(): void
    {
        Http::fake([
            'https://wilayah.id/api/provinces.json' => Http::response([
                'data' => [
                    ['code' => '32', 'name' => 'Jawa Barat'],
                    ['code' => '33', 'name' => 'Jawa Tengah'],
                ],
            ], 200),
        ]);

        $service = app(WilayahService::class);
        $provinces = $service->getProvinces();

        $this->assertCount(2, $provinces);
        $this->assertEquals('Jawa Barat', $provinces[0]['name']);
        $this->assertTrue(Cache::has('wilayah_provinces'));

        // Panggilan kedua membaca dari cache tanpa request HTTP baru
        Http::fake([
            'https://wilayah.id/api/provinces.json' => Http::response([], 500),
        ]);

        $cachedProvinces = $service->getProvinces();
        $this->assertCount(2, $cachedProvinces);
    }

    /**
     * Test WilayahService mengambil data kabupaten, kecamatan, dan desa.
     */
    public function test_wilayah_service_fetches_cascaded_regions(): void
    {
        Http::fake([
            'https://wilayah.id/api/regencies/32.json' => Http::response([
                'data' => [['code' => '32.01', 'name' => 'Kabupaten Bogor']],
            ], 200),
            'https://wilayah.id/api/districts/32.01.json' => Http::response([
                'data' => [['code' => '32.01.01', 'name' => 'Cibinong']],
            ], 200),
            'https://wilayah.id/api/villages/32.01.01.json' => Http::response([
                'data' => [['code' => '32.01.01.2001', 'name' => 'Sukamaju']],
            ], 200),
        ]);

        $service = app(WilayahService::class);

        $regencies = $service->getRegencies('32');
        $this->assertCount(1, $regencies);
        $this->assertEquals('Kabupaten Bogor', $regencies[0]['name']);

        $districts = $service->getDistricts('32.01');
        $this->assertCount(1, $districts);
        $this->assertEquals('Cibinong', $districts[0]['name']);

        $villages = $service->getVillages('32.01.01');
        $this->assertCount(1, $villages);
        $this->assertEquals('Sukamaju', $villages[0]['name']);
    }

    /**
     * Test endpoint API admin wilayah mengembalikan response JSON yang valid.
     */
    public function test_admin_can_access_wilayah_api_endpoints(): void
    {
        Http::fake([
            'https://wilayah.id/api/provinces.json' => Http::response([
                'data' => [['code' => '32', 'name' => 'Jawa Barat']],
            ], 200),
            'https://wilayah.id/api/regencies/32.json' => Http::response([
                'data' => [['code' => '32.01', 'name' => 'Kabupaten Bogor']],
            ], 200),
            'https://wilayah.id/api/districts/32.01.json' => Http::response([
                'data' => [['code' => '32.01.01', 'name' => 'Cibinong']],
            ], 200),
            'https://wilayah.id/api/villages/32.01.01.json' => Http::response([
                'data' => [['code' => '32.01.01.2001', 'name' => 'Sukamaju']],
            ], 200),
        ]);

        $responseProv = $this->actingAs($this->superadmin)->getJson('/admin/api/wilayah/provinces');
        $responseProv->assertStatus(200);
        $responseProv->assertJsonPath('success', true);
        $responseProv->assertJsonPath('data.0.name', 'Jawa Barat');

        $responseKab = $this->actingAs($this->superadmin)->getJson('/admin/api/wilayah/regencies/32');
        $responseKab->assertStatus(200);
        $responseKab->assertJsonPath('data.0.name', 'Kabupaten Bogor');

        $responseKec = $this->actingAs($this->superadmin)->getJson('/admin/api/wilayah/districts/32.01');
        $responseKec->assertStatus(200);
        $responseKec->assertJsonPath('data.0.name', 'Cibinong');

        $responseDesa = $this->actingAs($this->superadmin)->getJson('/admin/api/wilayah/villages/32.01.01');
        $responseDesa->assertStatus(200);
        $responseDesa->assertJsonPath('data.0.name', 'Sukamaju');
    }

    /**
     * Test pengguna non-admin (warga / tamu) tidak dapat mengakses API wilayah internal.
     */
    public function test_non_admin_cannot_access_wilayah_api(): void
    {
        $response = $this->actingAs($this->warga)->getJson('/admin/api/wilayah/provinces');
        $this->assertTrue(in_array($response->status(), [302, 403]));
    }
}
