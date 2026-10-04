<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LetterRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wargaUser = User::where('email', 'warga@sidesa.id')->first();
        $rtUser = User::where('email', 'rt@sidesa.id')->first();
        $staffUser = User::where('email', 'perangkat@sidesa.id')->first();
        $kadesUser = User::where('email', 'kades@sidesa.id')->first();

        $resident = Resident::where('nik', '3201011508900001')->first();

        if (! $wargaUser || ! $resident) {
            return;
        }

        $sktm = LetterTemplate::where('code', 'SKTM')->first();
        $skck = LetterTemplate::where('code', 'SKCK')->first();
        $domisili = LetterTemplate::where('code', 'DOMISILI')->first();
        $sku = LetterTemplate::where('code', 'SKU')->first();

        // 1. Surat SKTM - Menunggu Verifikasi RT/RW (pending_rt)
        if ($sktm) {
            LetterRequest::updateOrCreate(
                ['request_number' => 'REQ-20261001-0001'],
                [
                    'letter_template_id' => $sktm->id,
                    'resident_id' => $resident->id,
                    'user_id' => $wargaUser->id,
                    'purpose' => 'Persyaratan pengajuan beasiswa pendidikan perguruan tinggi',
                    'extra_data' => ['school_or_institution' => 'Universitas Indonesia'],
                    'status' => LetterRequest::STATUS_PENDING_RT,
                    'qr_token' => Str::random(32),
                    'created_at' => Carbon::now()->subHours(2),
                    'updated_at' => Carbon::now()->subHours(2),
                ]
            );
        }

        // 2. Surat Pengantar SKCK - Menunggu Verifikasi Staf Desa (pending_staff)
        if ($skck) {
            LetterRequest::updateOrCreate(
                ['request_number' => 'REQ-20261001-0002'],
                [
                    'letter_template_id' => $skck->id,
                    'resident_id' => $resident->id,
                    'user_id' => $wargaUser->id,
                    'purpose' => 'Persyaratan pendaftaran seleksi Calon Pegawai Negeri Sipil (CPNS)',
                    'extra_data' => [],
                    'status' => LetterRequest::STATUS_PENDING_STAFF,
                    'rt_verified_at' => Carbon::now()->subHours(5),
                    'rt_verified_by' => $rtUser?->id,
                    'rt_notes' => 'Warga berdomisili tetap dan berkelakuan baik di lingkungan RT 001.',
                    'qr_token' => Str::random(32),
                    'created_at' => Carbon::now()->subHours(6),
                    'updated_at' => Carbon::now()->subHours(5),
                ]
            );
        }

        // 3. Surat Keterangan Usaha (SKU) - Menunggu TTE Kades (pending_kades)
        if ($sku) {
            LetterRequest::updateOrCreate(
                ['request_number' => 'REQ-20261001-0003'],
                [
                    'letter_template_id' => $sku->id,
                    'resident_id' => $resident->id,
                    'user_id' => $wargaUser->id,
                    'purpose' => 'Pengajuan tambahan modal usaha Kredit Usaha Rakyat (KUR) BRI',
                    'extra_data' => [
                        'business_name' => 'Toko Kelontong Berkah Mandiri',
                        'business_location' => 'Jl. Merpati No. 12 RT 001 Sukamaju',
                        'business_since' => '2021',
                    ],
                    'status' => LetterRequest::STATUS_PENDING_KADES,
                    'rt_verified_at' => Carbon::now()->subHours(8),
                    'rt_verified_by' => $rtUser?->id,
                    'rt_notes' => 'Lokasi usaha aktif dan benar berada di RT 001.',
                    'staff_verified_at' => Carbon::now()->subHours(4),
                    'staff_verified_by' => $staffUser?->id,
                    'staff_notes' => 'Berkas persyaratan fotokopi KTP, KK, dan foto tempat usaha lengkap.',
                    'qr_token' => Str::random(32),
                    'created_at' => Carbon::now()->subHours(9),
                    'updated_at' => Carbon::now()->subHours(4),
                ]
            );
        }

        // 4. Surat Keterangan Domisili - Sudah Selesai & Disahkan (approved)
        if ($domisili) {
            LetterRequest::updateOrCreate(
                ['request_number' => 'REQ-20261001-0004'],
                [
                    'letter_template_id' => $domisili->id,
                    'resident_id' => $resident->id,
                    'user_id' => $wargaUser->id,
                    'letter_number' => '470/025/DOMISILI/Ds/2026',
                    'purpose' => 'Kelengkapan administrasi pembukaan rekening tabungan bank',
                    'extra_data' => [],
                    'status' => LetterRequest::STATUS_APPROVED,
                    'rt_verified_at' => Carbon::now()->subDays(2),
                    'rt_verified_by' => $rtUser?->id,
                    'rt_notes' => 'Data domisili sesuai kartu keluarga.',
                    'staff_verified_at' => Carbon::now()->subDays(2)->addHours(2),
                    'staff_verified_by' => $staffUser?->id,
                    'staff_notes' => 'Berkas valid.',
                    'kades_approved_at' => Carbon::now()->subDays(2)->addHours(4),
                    'kades_approved_by' => $kadesUser?->id,
                    'kades_notes' => 'Disetujui dan ditandatangani secara elektronik.',
                    'qr_token' => Str::random(32),
                    'signed_at' => Carbon::now()->subDays(2)->addHours(4),
                    'created_at' => Carbon::now()->subDays(2)->subHours(2),
                    'updated_at' => Carbon::now()->subDays(2)->addHours(4),
                ]
            );
        }
    }
}
