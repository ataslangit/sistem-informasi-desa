<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use App\Models\Setting;
use Illuminate\Contracts\View\View;

class LetterVerificationController extends Controller
{
    /**
     * Halaman verifikasi publik keabsahan TTE dan dokumen surat.
     */
    public function verify(string $qrToken): View
    {
        $letter = LetterRequest::with(['template', 'resident', 'kadesApprover'])
            ->where('qr_token', $qrToken)
            ->first();

        $villageName = Setting::get('village_name', 'Sukamaju');
        $districtName = Setting::get('district_name', 'Cibinong');
        $regencyName = Setting::get('regency_name', 'Bogor');

        return view('public.verify_letter', compact(
            'letter',
            'villageName',
            'districtName',
            'regencyName'
        ));
    }
}
