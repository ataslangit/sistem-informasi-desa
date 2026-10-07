<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\InstallerService;
use App\Services\WilayahService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class InstallerController extends Controller
{
    public function __construct(
        protected InstallerService $installerService,
        protected WilayahService $wilayahService
    ) {}

    /**
     * Langkah 1: Halaman Selamat Datang, Pengecekan Syarat Sistem & Izin Direktori.
     */
    public function index(): View
    {
        $requirements = $this->installerService->checkRequirements();
        $permissions = $this->installerService->checkPermissions();

        return view('installer.index', compact('requirements', 'permissions'));
    }

    /**
     * Langkah 2: Formulir Konfigurasi Basis Data (MySQL / MariaDB).
     */
    public function database(): View|RedirectResponse
    {
        $requirements = $this->installerService->checkRequirements();
        $permissions = $this->installerService->checkPermissions();

        if (! $requirements['all_passed'] || ! $permissions['all_passed']) {
            return redirect()->route('installer.index')
                ->with('error', 'Harap lengkapi semua persyaratan sistem dan izin berkas sebelum melanjutkan.');
        }

        $dbConfig = session('installer_db', [
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'sidesa'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
        ]);

        return view('installer.database', compact('dbConfig'));
    }

    /**
     * Uji & Simpan Konfigurasi Basis Data.
     */
    public function storeDatabase(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'host' => ['required', 'string'],
            'port' => ['required', 'numeric'],
            'database' => ['required', 'string'],
            'username' => ['required', 'string'],
            'password' => ['nullable', 'string'],
        ]);

        $test = $this->installerService->testDatabaseConnection(
            $validated['host'],
            (string) $validated['port'],
            $validated['database'],
            $validated['username'],
            $validated['password'] ?? ''
        );

        if (! $test['success']) {
            return back()->withInput()->with('error', $test['message']);
        }

        session(['installer_db' => $validated]);

        return redirect()->route('installer.setup')
            ->with('success', 'Koneksi ke basis data terverifikasi dengan sukses! Silakan lanjutkan konfigurasi instansi desa dan administrator.');
    }

    /**
     * Langkah 3: Formulir Identitas Desa, Akun Super Administrator & Opsi Demo Data.
     */
    /**
     * Langkah 3: Formulir Identitas Desa, Akun Super Administrator & Opsi Demo Data.
     */
    public function setup(): View|RedirectResponse
    {
        if (! session()->has('installer_db')) {
            return redirect()->route('installer.database')
                ->with('warning', 'Silakan konfigurasikan koneksi basis data terlebih dahulu.');
        }

        $provinces = $this->wilayahService->getProvinces();

        return view('installer.setup', compact('provinces'));
    }

    /**
     * Langkah 4: Eksekusi Instalasi (Migrasi, Seeding, Pembuatan Admin, Identitas Desa).
     */
    public function process(Request $request): RedirectResponse
    {
        if (! session()->has('installer_db')) {
            return redirect()->route('installer.database')
                ->with('error', 'Sesi konfigurasi basis data telah kedaluwarsa. Silakan masukkan kembali.');
        }

        $validated = $request->validate([
            'village_name' => ['required', 'string', 'max:100'],
            'village_code' => ['nullable', 'string', 'max:20'],
            'subdistrict_name' => ['required', 'string', 'max:100'],
            'district_name' => ['required', 'string', 'max:100'],
            'province_name' => ['required', 'string', 'max:100'],
            'timezone' => ['required', 'string', 'in:Asia/Jakarta,Asia/Makassar,Asia/Jayapura'],
            'village_address' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'village_phone' => ['nullable', 'string', 'max:50'],
            'village_email' => ['nullable', 'string', 'email', 'max:100'],
            'admin_name' => ['required', 'string', 'max:100'],
            'admin_username' => ['required', 'string', 'alpha_dash', 'max:50'],
            'admin_email' => ['required', 'string', 'email', 'max:100'],
            'admin_password' => ['required', 'string', Password::min(8), 'confirmed'],
            'admin_phone' => ['nullable', 'string', 'max:25'],
            'load_demo_data' => ['nullable', 'boolean'],
        ]);

        $dbConfig = session('installer_db');

        $result = $this->installerService->runInstallation($dbConfig, $validated);

        if (! $result['success']) {
            return back()->withInput()->with('error', $result['message']);
        }

        session([
            'installer_completed' => [
                'village_name' => $validated['village_name'],
                'admin_username' => $validated['admin_username'],
                'admin_email' => $validated['admin_email'],
                'load_demo_data' => ! empty($validated['load_demo_data']),
            ],
        ]);

        session()->forget('installer_db');

        return redirect()->route('installer.completed');
    }

    /**
     * Langkah 5: Halaman Berhasil Terinstal (Selesai).
     */
    public function completed(): View|RedirectResponse
    {
        $info = session('installer_completed');

        return view('installer.completed', compact('info'));
    }

    /**
     * Endpoint API Wilayah: Daftar Provinsi se-Indonesia.
     */
    public function wilayahProvinces(): JsonResponse
    {
        $data = $this->wilayahService->getProvinces();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Endpoint API Wilayah: Daftar Kabupaten/Kota berdasarkan kode provinsi.
     */
    public function wilayahRegencies(string $provinceCode): JsonResponse
    {
        $data = $this->wilayahService->getRegencies($provinceCode);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Endpoint API Wilayah: Daftar Kecamatan berdasarkan kode kabupaten/kota.
     */
    public function wilayahDistricts(string $regencyCode): JsonResponse
    {
        $data = $this->wilayahService->getDistricts($regencyCode);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Endpoint API Wilayah: Daftar Desa/Kelurahan berdasarkan kode kecamatan.
     */
    public function wilayahVillages(string $districtCode): JsonResponse
    {
        $data = $this->wilayahService->getVillages($districtCode);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
