<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Family;
use App\Models\Setting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdfInstance;
use Carbon\Carbon;

class FamilyPdfService
{
    /**
     * Generate instance DomPDF untuk Salinan Kartu Keluarga (Register Desa).
     */
    public function generatePdf(Family $family, ?User $downloadedBy = null): DomPdfInstance
    {
        $family->load(['headOfFamily', 'members' => function ($q): void {
            $q->where('status', 'active')
                ->orderByRaw("CASE 
                    WHEN family_relationship_status = 'Kepala Keluarga' THEN 1 
                    WHEN family_relationship_status = 'Istri' THEN 2 
                    WHEN family_relationship_status = 'Suami' THEN 3
                    WHEN family_relationship_status = 'Anak' THEN 4 
                    ELSE 5 
                END, birth_date ASC");
        }]);

        $villageName = Setting::get('village_name', 'Sukamaju');
        $districtName = Setting::get('district_name', 'Cibinong');
        $regencyName = Setting::get('regency_name', 'Bogor');
        $provinceName = Setting::get('province_name', 'Jawa Barat');
        $villageAddress = Setting::get('village_address', 'Jl. Raya Desa No. 01');
        $postalCode = $family->postal_code ?: Setting::get('village_postal_code', '16911');

        // Cari Pejabat Kepala Desa
        $kadesUser = User::whereHas('roles', function ($q): void {
            $q->where('name', 'kades');
        })->first();

        $kadesName = $kadesUser ? $kadesUser->name : 'H. Mulyadi, S.Sos.';
        $kadesNip = is_array($kadesUser?->metadata) && isset($kadesUser->metadata['nip'])
            ? $kadesUser->metadata['nip']
            : null;

        $downloadedByName = $downloadedBy ? $downloadedBy->name : 'Administrator Kependudukan';
        $downloadedAt = Carbon::now()->isoFormat('D MMMM Y HH:mm:ss').' WIB';

        $data = [
            'family' => $family,
            'members' => $family->members,
            'headOfFamily' => $family->headOfFamily,
            'villageName' => $villageName,
            'districtName' => $districtName,
            'regencyName' => $regencyName,
            'provinceName' => $provinceName,
            'villageAddress' => $villageAddress,
            'postalCode' => $postalCode,
            'kadesName' => $kadesName,
            'kadesNip' => $kadesNip,
            'downloadedByName' => $downloadedByName,
            'downloadedAt' => $downloadedAt,
            'currentDateIndo' => Carbon::now()->isoFormat('D MMMM Y'),
        ];

        /** @var DomPdfInstance $pdf */
        $pdf = Pdf::loadView('pdf.family_card', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf;
    }
}
