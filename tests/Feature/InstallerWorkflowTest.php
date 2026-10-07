<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Services\InstallerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InstallerWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected string $lockFile;

    protected bool $lockFileExisted = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->lockFile = storage_path('installed');
        $this->lockFileExisted = file_exists($this->lockFile);
    }

    protected function tearDown(): void
    {
        if ($this->lockFileExisted && ! file_exists($this->lockFile)) {
            touch($this->lockFile);
        } elseif (! $this->lockFileExisted && file_exists($this->lockFile)) {
            @unlink($this->lockFile);
        }
        parent::tearDown();
    }

    /**
     * Test jika belum diinstal, mengakses halaman web akan dialihkan ke /install.
     */
    public function test_uninstalled_system_redirects_to_installer(): void
    {
        config(['installer.simulate_uninstalled' => true]);

        $response = $this->get('/');

        $response->assertRedirect('/install');
    }

    /**
     * Test halaman langkah 1 (persyaratan sistem) dapat diakses dengan sukses.
     */
    public function test_installer_step_one_requirements_page_is_accessible(): void
    {
        config(['installer.simulate_uninstalled' => true]);

        $response = $this->get('/install');

        $response->assertStatus(200);
        $response->assertSee('SiDesa Installer');
        $response->assertSee('Langkah 1: Pengecekan Persyaratan Server');
        $response->assertSee('Versi PHP Lingkungan');
        $response->assertSee('Hak Akses Tulis Direktori');
    }

    /**
     * Test halaman langkah 2 (basis data) dapat diakses.
     */
    public function test_installer_step_two_database_page_is_accessible(): void
    {
        config(['installer.simulate_uninstalled' => true]);

        $response = $this->get('/install/database');

        $response->assertStatus(200);
        $response->assertSee('Langkah 2: Pengaturan Basis Data');
        $response->assertSee('Host Basis Data');
    }

    /**
     * Test validasi gagal jika koneksi basis data tidak valid.
     */
    public function test_database_step_fails_on_invalid_connection(): void
    {
        config(['installer.simulate_uninstalled' => true]);

        $response = $this->post('/install/database', [
            'host' => 'invalid-host-9999.test',
            'port' => 3306,
            'database' => 'non_existent_db',
            'username' => 'wrong_user',
            'password' => 'wrong_pass',
        ]);

        $response->assertSessionHas('error');
    }

    /**
     * Test langkah database berhasil jika kredensial benar dan mengarahkan ke setup.
     */
    public function test_database_step_succeeds_with_valid_connection(): void
    {
        config(['installer.simulate_uninstalled' => true]);

        // Gunakan kredensial koneksi aktif testing / sqlite / mysql
        $dbHost = config('database.connections.mysql.host', '127.0.0.1');
        $dbPort = config('database.connections.mysql.port', 3306);
        $dbName = config('database.connections.mysql.database', 'sidesa');
        $dbUser = config('database.connections.mysql.username', 'root');
        $dbPass = config('database.connections.mysql.password', '');

        // Mock testDatabaseConnection pada instance InstallerService
        $this->mock(InstallerService::class, function ($mock) {
            $mock->shouldReceive('testDatabaseConnection')
                ->once()
                ->andReturn(['success' => true, 'message' => 'Koneksi berhasil']);
        });

        $response = $this->post('/install/database', [
            'host' => $dbHost,
            'port' => $dbPort,
            'database' => $dbName,
            'username' => $dbUser,
            'password' => $dbPass,
        ]);

        $response->assertRedirect('/install/setup');
        $response->assertSessionHas('success');
        $response->assertSessionHas('installer_db');
    }

    /**
     * Test langkah setup identitas desa dan akun administrator dapat diakses jika database sudah tervalidasi.
     */
    public function test_setup_page_accessible_with_stored_db_session(): void
    {
        config(['installer.simulate_uninstalled' => true]);

        $response = $this->withSession([
            'installer_db' => [
                'host' => '127.0.0.1',
                'port' => 3306,
                'database' => 'sidesa',
                'username' => 'root',
                'password' => '',
            ],
        ])->get('/install/setup');

        $response->assertStatus(200);
        $response->assertSee('Langkah 3: Identitas Desa');
        $response->assertSee('Nama Resmi Desa');
        $response->assertSee('Akun Super Administrator Utama');
        $response->assertSee('Muat Data Demo / Contoh');
    }

    /**
     * Test proses instalasi mengeksekusi pembuatan admin dan konfigurasi desa.
     */
    public function test_installation_process_executes_successfully(): void
    {
        config(['installer.simulate_uninstalled' => true]);

        $setupData = [
            'village_name' => 'Desa Karanganyar Sejahtera',
            'village_code' => '33.01.01.2005',
            'subdistrict_name' => 'Kecamatan Makmur Sejati',
            'district_name' => 'Kabupaten Sukabumi',
            'province_name' => 'Jawa Barat',
            'village_address' => 'Jl. Pelabuhan Ratu No. 99, Karanganyar',
            'postal_code' => '43364',
            'village_phone' => '081234567899',
            'village_email' => 'desa@karanganyar.desa.id',
            'admin_name' => 'Admin Baru Sukamaju',
            'admin_username' => 'admin_baru',
            'admin_email' => 'admin.baru@desa.id',
            'admin_password' => 'passwordSuper123',
            'admin_password_confirmation' => 'passwordSuper123',
            'admin_phone' => '081299991111',
            'load_demo_data' => '0',
        ];

        $dbSession = [
            'host' => '127.0.0.1',
            'port' => 3306,
            'database' => 'sidesa',
            'username' => 'root',
            'password' => '',
        ];

        // Mock InstallerService runInstallation agar tidak menjalankan migrate fresh di tengah testing refresh database
        $this->mock(InstallerService::class, function ($mock) use ($setupData) {
            $mock->shouldReceive('runInstallation')
                ->once()
                ->andReturnUsing(function () use ($setupData) {
                    // Update user admin
                    $admin = User::updateOrCreate(
                        ['email' => $setupData['admin_email']],
                        [
                            'name' => $setupData['admin_name'],
                            'username' => $setupData['admin_username'],
                            'password' => Hash::make($setupData['admin_password']),
                            'is_active' => true,
                        ]
                    );
                    $admin->syncRoles(['superadmin']);

                    Setting::set('village_name', $setupData['village_name']);
                    Setting::set('subdistrict_name', $setupData['subdistrict_name']);
                    Setting::set('village_address', $setupData['village_address']);
                    Setting::set('postal_code', $setupData['postal_code']);
                    Setting::set('village_postal_code', $setupData['postal_code']);
                    Setting::set('village_phone', $setupData['village_phone']);
                    Setting::set('village_email', $setupData['village_email']);

                    InstallerService::createLockFile([
                        'village_name' => $setupData['village_name'],
                        'admin_email' => $setupData['admin_email'],
                    ]);

                    return ['success' => true, 'message' => 'Instalasi sukses'];
                });
        });

        $response = $this->withSession(['installer_db' => $dbSession])
            ->post('/install/process', $setupData);

        $response->assertRedirect('/install/completed');

        $this->assertDatabaseHas('users', [
            'email' => 'admin.baru@desa.id',
            'username' => 'admin_baru',
        ]);

        $this->assertEquals('Desa Karanganyar Sejahtera', Setting::get('village_name'));
        $this->assertEquals('Jl. Pelabuhan Ratu No. 99, Karanganyar', Setting::get('village_address'));
        $this->assertEquals('43364', Setting::get('postal_code'));
        $this->assertEquals('081234567899', Setting::get('village_phone'));
        $this->assertEquals('desa@karanganyar.desa.id', Setting::get('village_email'));
    }

    /**
     * Test jika sistem sudah terinstal, jalur /install diblokir dan dialihkan ke /.
     */
    public function test_installed_system_redirects_away_from_installer(): void
    {
        // Secara default isInstalled() true di environment testing
        $response = $this->get('/install');

        $response->assertRedirect('/');
    }

    /**
     * Test endpoint wilayah API pada installer dapat diakses untuk penelusuran hierarki wilayah.
     */
    public function test_installer_wilayah_api_endpoints_return_data(): void
    {
        config(['installer.simulate_uninstalled' => true]);

        // 1. Provinces
        $provResponse = $this->getJson('/install/wilayah/provinces');
        $provResponse->assertStatus(200);
        $provResponse->assertJson(['success' => true]);

        // 2. Regencies
        $regResponse = $this->getJson('/install/wilayah/regencies/32');
        $regResponse->assertStatus(200);
        $regResponse->assertJson(['success' => true]);

        // 3. Districts
        $distResponse = $this->getJson('/install/wilayah/districts/32.01');
        $distResponse->assertStatus(200);
        $distResponse->assertJson(['success' => true]);

        // 4. Villages
        $villResponse = $this->getJson('/install/wilayah/villages/32.01.01');
        $villResponse->assertStatus(200);
        $villResponse->assertJson(['success' => true]);
    }
}
