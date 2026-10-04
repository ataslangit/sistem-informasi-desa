<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\LetterRequest;
use App\Models\Setting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdfInstance;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LetterPdfService
{
    public function __construct(
        protected LetterService $letterService
    ) {}

    /**
     * Generate PDF instance surat resmi.
     */
    public function generatePdf(LetterRequest $letterRequest): DomPdfInstance
    {
        $parsedContent = $this->letterService->parseTemplateContent($letterRequest);

        $villageName = Setting::get('village_name', 'Sukamaju');
        $districtName = Setting::get('district_name', 'Cibinong');
        $regencyName = Setting::get('regency_name', 'Bogor');
        $villageAddress = Setting::get('village_address', 'Jl. Raya Desa No. 01');
        $postalCode = Setting::get('village_postal_code', '16911');
        $villagePhone = Setting::get('village_phone', '021-87654321');
        $villageEmail = Setting::get('village_email', 'desa.sukamaju@sidesa.id');

        // URL untuk verifikasi scan QR
        $verificationUrl = url('/verify/letter/'.$letterRequest->qr_token);

        // QR Code SVG encoded Base64
        $qrSvg = QrCode::format('svg')->size(100)->margin(1)->generate($verificationUrl);
        $qrBase64 = base64_encode((string) $qrSvg);

        // Cari Kepala Desa
        $kadesUser = $letterRequest->kadesApprover ?? User::whereHas('roles', function ($q) {
            $q->where('name', 'kades');
        })->first();

        $kadesName = $kadesUser ? $kadesUser->name : 'H. Mulyadi, S.Sos.';
        $kadesNip = is_array($kadesUser?->metadata) && isset($kadesUser->metadata['nip'])
            ? $kadesUser->metadata['nip']
            : '197508152005011002';

        $data = [
            'letter' => $letterRequest,
            'content' => $parsedContent,
            'villageName' => $villageName,
            'districtName' => $districtName,
            'regencyName' => $regencyName,
            'villageAddress' => $villageAddress,
            'postalCode' => $postalCode,
            'villagePhone' => $villagePhone,
            'villageEmail' => $villageEmail,
            'verificationUrl' => $verificationUrl,
            'qrBase64' => $qrBase64,
            'kadesName' => $kadesName,
            'kadesNip' => $kadesNip,
            'dateFormatted' => $letterRequest->signed_at
                ? $letterRequest->signed_at->translatedFormat('d F Y')
                : Carbon::now()->translatedFormat('d F Y'),
        ];

        /** @var DomPdfInstance $pdf */
        $pdf = Pdf::loadView('pdf.official_letter', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }
}
