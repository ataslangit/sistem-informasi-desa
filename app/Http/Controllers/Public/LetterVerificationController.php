<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use App\Models\Setting;
use App\Services\TteService;
use Illuminate\Contracts\View\View;

class LetterVerificationController extends Controller
{
    /**
     * Halaman verifikasi publik keabsahan TTE dan dokumen surat.
     * Menerapkan audit integritas kriptografis sesuai UU No. 1/2024 & PP No. 71/2019.
     */
    public function verify(string $qrToken, TteService $tteService): View
    {
        $letter = LetterRequest::with(['template', 'resident', 'kadesApprover'])
            ->where('qr_token', $qrToken)
            ->first();

        $tteVerification = null;
        if ($letter && $letter->isApproved()) {
            $tteVerification = $tteService->verify($letter);
        }

        $villageName = (string) Setting::get('village_name', 'Sukamaju');
        $districtName = (string) Setting::get('district_name', 'Cibinong');
        $regencyName = (string) Setting::get('regency_name', 'Bogor');

        return view('public.verify_letter', compact(
            'letter',
            'tteVerification',
            'villageName',
            'districtName',
            'regencyName'
        ));
    }
}
