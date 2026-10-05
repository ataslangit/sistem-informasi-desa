<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WilayahService;
use Illuminate\Http\JsonResponse;

class WilayahApiController extends Controller
{
    public function __construct(
        protected WilayahService $wilayahService
    ) {}

    /**
     * Mengambil daftar provinsi se-Indonesia.
     */
    public function provinces(): JsonResponse
    {
        $data = $this->wilayahService->getProvinces();

        return response()->json([
            'success' => true,
            'data' => $data,
        ])
            ->header('Cache-Control', 'public, max-age=604800, stale-while-revalidate=86400')
            ->setEtag(md5(json_encode($data)));
    }

    /**
     * Mengambil daftar kabupaten / kota berdasarkan kode provinsi.
     */
    public function regencies(string $provinceCode): JsonResponse
    {
        $data = $this->wilayahService->getRegencies($provinceCode);

        return response()->json([
            'success' => true,
            'data' => $data,
        ])
            ->header('Cache-Control', 'public, max-age=604800, stale-while-revalidate=86400')
            ->setEtag(md5(json_encode($data)));
    }

    /**
     * Mengambil daftar kecamatan berdasarkan kode kabupaten / kota.
     */
    public function districts(string $regencyCode): JsonResponse
    {
        $data = $this->wilayahService->getDistricts($regencyCode);

        return response()->json([
            'success' => true,
            'data' => $data,
        ])
            ->header('Cache-Control', 'public, max-age=604800, stale-while-revalidate=86400')
            ->setEtag(md5(json_encode($data)));
    }

    /**
     * Mengambil daftar desa / kelurahan berdasarkan kode kecamatan.
     */
    public function villages(string $districtCode): JsonResponse
    {
        $data = $this->wilayahService->getVillages($districtCode);

        return response()->json([
            'success' => true,
            'data' => $data,
        ])
            ->header('Cache-Control', 'public, max-age=604800, stale-while-revalidate=86400')
            ->setEtag(md5(json_encode($data)));
    }
}
