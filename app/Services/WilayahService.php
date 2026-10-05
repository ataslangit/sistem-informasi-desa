<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WilayahService
{
    protected string $baseUrl = 'https://wilayah.id/api';

    protected int $cacheTtl = 604800; // 7 hari (60 * 60 * 24 * 7 detik)

    /**
     * Mengambil daftar seluruh provinsi di Indonesia.
     *
     * @return array<int, array{code: string, name: string}>
     */
    public function getProvinces(): array
    {
        return Cache::remember('wilayah_provinces', $this->cacheTtl, function () {
            try {
                $response = Http::timeout(8)
                    ->retry(2, 200)
                    ->get("{$this->baseUrl}/provinces.json");

                if ($response->successful()) {
                    return $response->json('data') ?? [];
                }
            } catch (\Throwable $e) {
                Log::warning('Gagal mengambil data provinsi dari wilayah.id: '.$e->getMessage());
            }

            return [];
        });
    }

    /**
     * Mengambil daftar kabupaten / kota berdasarkan kode provinsi.
     *
     * @return array<int, array{code: string, name: string}>
     */
    public function getRegencies(string $provinceCode): array
    {
        $cleanCode = trim($provinceCode);
        $cacheKey = "wilayah_regencies_{$cleanCode}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($cleanCode) {
            try {
                $response = Http::timeout(8)
                    ->retry(2, 200)
                    ->get("{$this->baseUrl}/regencies/{$cleanCode}.json");

                if ($response->successful()) {
                    return $response->json('data') ?? [];
                }
            } catch (\Throwable $e) {
                Log::warning("Gagal mengambil kabupaten untuk provinsi {$cleanCode} dari wilayah.id: ".$e->getMessage());
            }

            return [];
        });
    }

    /**
     * Mengambil daftar kecamatan berdasarkan kode kabupaten / kota.
     *
     * @return array<int, array{code: string, name: string}>
     */
    public function getDistricts(string $regencyCode): array
    {
        $cleanCode = trim($regencyCode);
        $cacheKey = "wilayah_districts_{$cleanCode}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($cleanCode) {
            try {
                $response = Http::timeout(8)
                    ->retry(2, 200)
                    ->get("{$this->baseUrl}/districts/{$cleanCode}.json");

                if ($response->successful()) {
                    return $response->json('data') ?? [];
                }
            } catch (\Throwable $e) {
                Log::warning("Gagal mengambil kecamatan untuk kabupaten {$cleanCode} dari wilayah.id: ".$e->getMessage());
            }

            return [];
        });
    }

    /**
     * Mengambil daftar desa / kelurahan berdasarkan kode kecamatan.
     *
     * @return array<int, array{code: string, name: string}>
     */
    public function getVillages(string $districtCode): array
    {
        $cleanCode = trim($districtCode);
        $cacheKey = "wilayah_villages_{$cleanCode}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($cleanCode) {
            try {
                $response = Http::timeout(8)
                    ->retry(2, 200)
                    ->get("{$this->baseUrl}/villages/{$cleanCode}.json");

                if ($response->successful()) {
                    return $response->json('data') ?? [];
                }
            } catch (\Throwable $e) {
                Log::warning("Gagal mengambil desa/kelurahan untuk kecamatan {$cleanCode} dari wilayah.id: ".$e->getMessage());
            }

            return [];
        });
    }
}
