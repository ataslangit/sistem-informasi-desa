<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDO;
use Throwable;

class InstallerService
{
    /**
     * Memeriksa apakah aplikasi SiDesa sudah berhasil diinstal.
     */
    public static function isInstalled(): bool
    {
        if (app()->environment('testing')) {
            return config('installer.simulate_uninstalled', false) ? false : true;
        }

        return file_exists(storage_path('installed'));
    }

    /**
     * Mengambil path file penanda instalasi.
     */
    public static function getLockFilePath(): string
    {
        return storage_path('installed');
    }

    /**
     * Membuat berkas kunci penanda bahwa instalasi telah selesai.
     */
    public static function createLockFile(array $meta = []): void
    {
        $data = [
            'installed_at' => now()->toIso8601String(),
            'app_version' => (string) config('app.version', '1.0.0'),
            'meta' => $meta,
        ];

        file_put_contents(storage_path('installed'), json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Memeriksa kesiapan spesifikasi server dan ekstensi PHP.
     *
     * @return array{all_passed: bool, php: array, extensions: array}
     */
    public function checkRequirements(): array
    {
        $minPhp = (string) config('installer.min_php_version', '8.1.0');
        $currentPhp = PHP_VERSION;
        $phpPassed = version_compare($currentPhp, $minPhp, '>=');

        $requiredExtensions = config('installer.required_extensions', []);
        $extensionsResult = [];
        $extensionsPassed = true;

        foreach ($requiredExtensions as $ext => $label) {
            $isLoaded = extension_loaded($ext);
            if (! $isLoaded) {
                $extensionsPassed = false;
            }

            $extensionsResult[$ext] = [
                'name' => $ext,
                'label' => $label,
                'status' => $isLoaded,
            ];
        }

        return [
            'all_passed' => $phpPassed && $extensionsPassed,
            'php' => [
                'required' => $minPhp,
                'current' => $currentPhp,
                'status' => $phpPassed,
            ],
            'extensions' => $extensionsResult,
        ];
    }

    /**
     * Memeriksa hak akses direktori penting aplikasi.
     *
     * @return array{all_passed: bool, directories: array}
     */
    public function checkPermissions(): array
    {
        $directories = config('installer.writable_directories', []);
        $dirResult = [];
        $allPassed = true;

        foreach ($directories as $dir => $label) {
            $fullPath = base_path($dir);
            $isWritable = is_dir($fullPath) ? is_writable($fullPath) : false;

            if (! $isWritable) {
                $allPassed = false;
            }

            $dirResult[$dir] = [
                'path' => $dir,
                'label' => $label,
                'status' => $isWritable,
            ];
        }

        // Cek berkas .env atau root jika .env belum dibuat
        $envPath = base_path('.env');
        $envWritable = file_exists($envPath) ? is_writable($envPath) : is_writable(base_path());
        if (! $envWritable) {
            $allPassed = false;
        }

        $dirResult['.env'] = [
            'path' => '.env',
            'label' => 'Berkas Konfigurasi Lingkungan (.env)',
            'status' => $envWritable,
        ];

        return [
            'all_passed' => $allPassed,
            'directories' => $dirResult,
        ];
    }

    /**
     * Menguji koneksi ke basis data MySQL/MariaDB menggunakan PDO.
     *
     * @return array{success: bool, message: string}
     */
    public function testDatabaseConnection(
        string $host,
        string $port,
        string $database,
        string $username,
        string $password
    ): array {
        try {
            $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
            new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5,
            ]);

            return [
                'success' => true,
                'message' => 'Koneksi ke basis data MySQL/MariaDB berhasil diverifikasi.',
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Gagal terhubung ke basis data: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Memperbarui konfigurasi berkas .env dengan nilai baru.
     */
    public function updateEnvironment(array $values): bool
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            $examplePath = base_path('.env.example');
            if (file_exists($examplePath)) {
                copy($examplePath, $envPath);
            } else {
                file_put_contents($envPath, '');
            }
        }

        $content = file_get_contents($envPath);
        if ($content === false) {
            return false;
        }

        foreach ($values as $key => $val) {
            $valStr = (string) $val;
            // Bungkus dengan tanda petik jika mengandung karakter khusus, spasi, atau tanda petik
            if ($valStr !== '' && (preg_match('/[\s#@=\'\"]/', $valStr) || str_starts_with($valStr, '"') || str_ends_with($valStr, '"'))) {
                $escapedVal = '"'.addcslashes($valStr, '"\\').'"';
            } else {
                $escapedVal = $valStr;
            }
            $pattern = "/^{$key}=.*/m";

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, "{$key}={$escapedVal}", $content);
            } else {
                $content .= "\n{$key}={$escapedVal}";
            }
        }

        return file_put_contents($envPath, $content) !== false;
    }

    /**
     * Menjalankan seluruh proses instalasi SiDesa.
     *
     * @param  array{host: string, port: string, database: string, username: string, password: string}  $dbConfig
     * @param array{
     *     village_name: string,
     *     village_code?: string,
     *     subdistrict_name: string,
     *     district_name: string,
     *     province_name: string,
     *     admin_name: string,
     *     admin_username: string,
     *     admin_email: string,
     *     admin_password: string,
     *     admin_phone?: string,
     *     load_demo_data?: bool
     * } $setupData
     * @return array{success: bool, message: string}
     */
    public function runInstallation(array $dbConfig, array $setupData): array
    {
        try {
            $timezone = $setupData['timezone'] ?? 'Asia/Jakarta';

            // 1. Simpan konfigurasi database dan zona waktu ke .env
            $this->updateEnvironment([
                'DB_HOST' => $dbConfig['host'],
                'DB_PORT' => $dbConfig['port'],
                'DB_DATABASE' => $dbConfig['database'],
                'DB_USERNAME' => $dbConfig['username'],
                'DB_PASSWORD' => $dbConfig['password'],
                'APP_TIMEZONE' => $timezone,
            ]);

            // 2. Set konfigurasi koneksi database runtime
            config([
                'database.connections.mysql.host' => $dbConfig['host'],
                'database.connections.mysql.port' => $dbConfig['port'],
                'database.connections.mysql.database' => $dbConfig['database'],
                'database.connections.mysql.username' => $dbConfig['username'],
                'database.connections.mysql.password' => $dbConfig['password'],
            ]);

            DB::purge('mysql');
            DB::reconnect('mysql');

            // 3. Generate APP_KEY jika belum ada
            if (empty(config('app.key'))) {
                Artisan::call('key:generate', ['--force' => true]);
            }

            // 4. Jalankan Migrasi Database
            Artisan::call('migrate', ['--force' => true]);

            // 5. Jalankan Seeder Baku / Master Data
            Artisan::call('db:seed', ['--class' => 'RoleAndPermissionSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'SettingSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'LetterTemplateSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'MenuSeeder', '--force' => true]);

            // 6. Buat Akun Super Administrator Utama
            $admin = User::updateOrCreate(
                ['email' => strtolower($setupData['admin_email'])],
                [
                    'name' => $setupData['admin_name'],
                    'username' => strtolower($setupData['admin_username']),
                    'password' => Hash::make($setupData['admin_password']),
                    'is_active' => true,
                    'metadata' => array_filter([
                        'phone' => $setupData['admin_phone'] ?? null,
                        'jabatan' => 'Super Administrator Sistem',
                    ]),
                ]
            );
            $admin->syncRoles(['superadmin']);

            // 7. Perbarui Data Pengaturan Identitas Desa
            Setting::set('village_name', $setupData['village_name'], 'village', 'Nama Resmi Desa');
            if (! empty($setupData['village_code'])) {
                Setting::set('village_code', $setupData['village_code'], 'village', 'Kode Wilayah Kemendagri Desa');
            }
            Setting::set('subdistrict_name', $setupData['subdistrict_name'], 'village', 'Nama Kecamatan');
            Setting::set('district_name', $setupData['district_name'], 'village', 'Nama Kabupaten / Kota');
            Setting::set('province_name', $setupData['province_name'], 'village', 'Nama Provinsi');
            Setting::set('app_title', 'SiDesa - Portal Resmi '.$setupData['village_name'], 'general', 'Judul Halaman Web Portal Publik');

            $villageAddress = ! empty($setupData['village_address'])
                ? $setupData['village_address']
                : ('Jl. Raya '.$setupData['village_name'].' No. 01, '.$setupData['subdistrict_name'].', '.$setupData['district_name']);
            Setting::set('village_address', $villageAddress, 'village', 'Alamat Kantor Desa');

            $postalCode = ! empty($setupData['postal_code'])
                ? $setupData['postal_code']
                : '16911';
            Setting::set('postal_code', $postalCode, 'village', 'Kode Pos Kantor Desa');
            Setting::set('village_postal_code', $postalCode, 'village', 'Kode Pos Kantor Desa');

            $villagePhone = ! empty($setupData['village_phone'])
                ? $setupData['village_phone']
                : ($setupData['admin_phone'] ?? '081234567890');
            Setting::set('village_phone', $villagePhone, 'village', 'Telepon / WhatsApp Kantor Desa');

            $villageEmail = ! empty($setupData['village_email'])
                ? $setupData['village_email']
                : ('kantor@'.\Illuminate\Support\Str::slug($setupData['village_name']).'.desa.id');
            Setting::set('village_email', $villageEmail, 'village', 'Email Resmi Kantor Desa');

            // Simpan konfigurasi timezone operasional desa
            Setting::set('timezone', $timezone, 'general', 'Zona Waktu Wilayah Desa (WIB/WITA/WIT)');
            date_default_timezone_set($timezone);
            config(['app.timezone' => $timezone]);

            // 8. Muat Data Demo jika dipilih oleh pengguna
            $loadDemo = ! empty($setupData['load_demo_data']);
            if ($loadDemo) {
                Artisan::call('db:seed', ['--class' => 'ResidentAndFamilySeeder', '--force' => true]);
                Artisan::call('db:seed', ['--class' => 'ContentSeeder', '--force' => true]);
                Artisan::call('db:seed', ['--class' => 'VillageBudgetAndMapSeeder', '--force' => true]);
                Artisan::call('db:seed', ['--class' => 'PpidSeeder', '--force' => true]);
            }

            // 9. Buat symlink storage jika belum ada
            if (! file_exists(public_path('storage'))) {
                Artisan::call('storage:link');
            }

            // 10. Tulis berkas penanda instalasi terkunci (lock file)
            self::createLockFile([
                'village_name' => $setupData['village_name'],
                'admin_username' => $setupData['admin_username'],
                'admin_email' => $setupData['admin_email'],
                'timezone' => $timezone,
                'demo_loaded' => $loadDemo,
            ]);

            return [
                'success' => true,
                'message' => 'Instalasi SiDesa berhasil diselesaikan dengan sukses!',
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses instalasi: '.$e->getMessage(),
            ];
        }
    }
}
