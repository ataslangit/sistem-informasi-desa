<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WilayahService
{
    protected string $baseUrl = 'https://wilayah.id/api';

    protected int $cacheTtl = 2592000; // 30 hari (dalam detik)

    protected string $storageDir;

    public function __construct()
    {
        $this->storageDir = storage_path('app/wilayah');
        if (! File::isDirectory($this->storageDir)) {
            File::makeDirectory($this->storageDir, 0755, true, true);
        }
    }

    /**
     * Mengambil daftar seluruh provinsi di Indonesia dengan persistent disk & cache storage.
     *
     * @return array<int, array{code: string, name: string}>
     */
    public function getProvinces(): array
    {
        $cacheKey = 'wilayah_provinces';
        $diskFile = $this->storageDir.'/provinces.json';

        // 1. Cek di Laravel Cache
        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached) && ! empty($cached)) {
                return $cached;
            }
        }

        // 2. Cek di file JSON persisten pada disk
        if (File::exists($diskFile)) {
            $diskContent = (string) File::get($diskFile);
            $decoded = json_decode($diskContent, true);
            if (is_array($decoded) && ! empty($decoded)) {
                Cache::put($cacheKey, $decoded, $this->cacheTtl);

                return $decoded;
            }
        }

        // 3. Ambil dari API wilayah.id
        try {
            $response = Http::timeout(8)
                ->retry(2, 200)
                ->get("{$this->baseUrl}/provinces.json");

            if ($response->successful()) {
                $data = $response->json('data');
                if (is_array($data) && ! empty($data)) {
                    File::put($diskFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    Cache::put($cacheKey, $data, $this->cacheTtl);

                    return $data;
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Gagal mengambil data provinsi dari wilayah.id: '.$e->getMessage());
        }

        return [];
    }

    /**
     * Mengambil daftar kabupaten / kota berdasarkan kode provinsi.
     *
     * @return array<int, array{code: string, name: string}>
     */
    public function getRegencies(string $provinceCode): array
    {
        $cleanCode = preg_replace('/[^0-9.]/', '', trim($provinceCode)) ?: $provinceCode;
        $cacheKey = "wilayah_regencies_{$cleanCode}";
        $diskFile = "{$this->storageDir}/regencies_{$cleanCode}.json";

        // 1. Cek di Laravel Cache
        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached) && ! empty($cached)) {
                return $cached;
            }
        }

        // 2. Cek di file JSON lokal disk
        if (File::exists($diskFile)) {
            $diskContent = (string) File::get($diskFile);
            $decoded = json_decode($diskContent, true);
            if (is_array($decoded) && ! empty($decoded)) {
                Cache::put($cacheKey, $decoded, $this->cacheTtl);

                return $decoded;
            }
        }

        // 3. Ambil dari API wilayah.id
        try {
            $response = Http::timeout(8)
                ->retry(2, 200)
                ->get("{$this->baseUrl}/regencies/{$cleanCode}.json");

            if ($response->successful()) {
                $data = $response->json('data');
                if (is_array($data) && ! empty($data)) {
                    File::put($diskFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    Cache::put($cacheKey, $data, $this->cacheTtl);

                    return $data;
                }
            }
        } catch (\Throwable $e) {
            Log::warning("Gagal mengambil kabupaten untuk provinsi {$cleanCode} dari wilayah.id: ".$e->getMessage());
        }

        return [];
    }

    /**
     * Mengambil daftar kecamatan berdasarkan kode kabupaten / kota.
     *
     * @return array<int, array{code: string, name: string}>
     */
    public function getDistricts(string $regencyCode): array
    {
        $cleanCode = preg_replace('/[^0-9.]/', '', trim($regencyCode)) ?: $regencyCode;
        $cacheKey = "wilayah_districts_{$cleanCode}";
        $diskFile = "{$this->storageDir}/districts_{$cleanCode}.json";

        // 1. Cek di Laravel Cache
        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached) && ! empty($cached)) {
                return $cached;
            }
        }

        // 2. Cek di file JSON lokal disk
        if (File::exists($diskFile)) {
            $diskContent = (string) File::get($diskFile);
            $decoded = json_decode($diskContent, true);
            if (is_array($decoded) && ! empty($decoded)) {
                Cache::put($cacheKey, $decoded, $this->cacheTtl);

                return $decoded;
            }
        }

        // 3. Ambil dari API wilayah.id
        try {
            $response = Http::timeout(8)
                ->retry(2, 200)
                ->get("{$this->baseUrl}/districts/{$cleanCode}.json");

            if ($response->successful()) {
                $data = $response->json('data');
                if (is_array($data) && ! empty($data)) {
                    File::put($diskFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    Cache::put($cacheKey, $data, $this->cacheTtl);

                    return $data;
                }
            }
        } catch (\Throwable $e) {
            Log::warning("Gagal mengambil kecamatan untuk kabupaten {$cleanCode} dari wilayah.id: ".$e->getMessage());
        }

        return [];
    }

    /**
     * Mengambil daftar desa / kelurahan berdasarkan kode kecamatan.
     *
     * @return array<int, array{code: string, name: string}>
     */
    public function getVillages(string $districtCode): array
    {
        $cleanCode = preg_replace('/[^0-9.]/', '', trim($districtCode)) ?: $districtCode;
        $cacheKey = "wilayah_villages_{$cleanCode}";
        $diskFile = "{$this->storageDir}/villages_{$cleanCode}.json";

        // 1. Cek di Laravel Cache
        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached) && ! empty($cached)) {
                return $cached;
            }
        }

        // 2. Cek di file JSON lokal disk
        if (File::exists($diskFile)) {
            $diskContent = (string) File::get($diskFile);
            $decoded = json_decode($diskContent, true);
            if (is_array($decoded) && ! empty($decoded)) {
                Cache::put($cacheKey, $decoded, $this->cacheTtl);

                return $decoded;
            }
        }

        // 3. Ambil dari API wilayah.id
        try {
            $response = Http::timeout(8)
                ->retry(2, 200)
                ->get("{$this->baseUrl}/villages/{$cleanCode}.json");

            if ($response->successful()) {
                $data = $response->json('data');
                if (is_array($data) && ! empty($data)) {
                    File::put($diskFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    Cache::put($cacheKey, $data, $this->cacheTtl);

                    return $data;
                }
            }
        } catch (\Throwable $e) {
            Log::warning("Gagal mengambil desa/kelurahan untuk kecamatan {$cleanCode} dari wilayah.id: ".$e->getMessage());
        }

        return [];
    }
}
