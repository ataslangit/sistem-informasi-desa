<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use App\Models\Resident;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use InvalidArgumentException;

class LetterService
{
    /**
     * Membuat pengajuan surat baru dari warga.
     */
    public function createRequest(
        User $user,
        Resident $resident,
        LetterTemplate $template,
        string $purpose,
        array $extraData = []
    ): LetterRequest {
        $requestNumber = $this->generateRequestNumber();
        $qrToken = Str::random(32);

        return LetterRequest::create([
            'request_number' => $requestNumber,
            'letter_template_id' => $template->id,
            'resident_id' => $resident->id,
            'user_id' => $user->id,
            'purpose' => trim($purpose),
            'extra_data' => $extraData,
            'status' => LetterRequest::STATUS_PENDING_RT,
            'qr_token' => $qrToken,
        ]);
    }

    /**
     * Tahap 1: Verifikasi oleh Pengurus RT / RW.
     */
    public function verifyByRt(LetterRequest $letterRequest, User $rtUser, ?string $notes = null): LetterRequest
    {
        if ($letterRequest->status !== LetterRequest::STATUS_PENDING_RT) {
            throw new InvalidArgumentException('Surat tidak berada pada tahapan verifikasi RT/RW.');
        }

        $letterRequest->update([
            'status' => LetterRequest::STATUS_PENDING_STAFF,
            'rt_verified_at' => Carbon::now(),
            'rt_verified_by' => $rtUser->id,
            'rt_notes' => $notes,
        ]);

        return $letterRequest;
    }

    /**
     * Bypass verifikasi RT/RW oleh Perangkat Desa / Administrator (cth: warga membawa pengantar fisik).
     * Melompati tahapan RT/RW dan langsung menaikkan status ke pending_kades.
     */
    public function bypassRtAndVerify(LetterRequest $letterRequest, User $staffUser, ?string $notes = null): LetterRequest
    {
        if ($letterRequest->status !== LetterRequest::STATUS_PENDING_RT) {
            throw new InvalidArgumentException('Bypass hanya dapat dilakukan pada permohonan yang berstatus menunggu verifikasi RT/RW.');
        }

        $now = Carbon::now();
        $rtNote = $notes
            ? "Bypass Verifikasi RT/RW oleh Staf ({$staffUser->name}): {$notes}"
            : "Diverifikasi administratif oleh Staf Desa ({$staffUser->name}) berdasarkan berkas fisik pengantar RT/RW.";

        $letterRequest->update([
            'status' => LetterRequest::STATUS_PENDING_KADES,
            'rt_verified_at' => $now,
            'rt_verified_by' => $staffUser->id,
            'rt_notes' => $rtNote,
            'staff_verified_at' => $now,
            'staff_verified_by' => $staffUser->id,
            'staff_notes' => $notes ?? 'Diverifikasi langsung oleh staf pelayanan desa.',
        ]);

        return $letterRequest;
    }

    /**
     * Tahap 2: Verifikasi berkas oleh Staf / Perangkat Desa.
     */
    public function verifyByStaff(LetterRequest $letterRequest, User $staffUser, ?string $notes = null): LetterRequest
    {
        if ($letterRequest->status !== LetterRequest::STATUS_PENDING_STAFF) {
            throw new InvalidArgumentException('Surat tidak berada pada tahapan verifikasi Staf Desa.');
        }

        $letterRequest->update([
            'status' => LetterRequest::STATUS_PENDING_KADES,
            'staff_verified_at' => Carbon::now(),
            'staff_verified_by' => $staffUser->id,
            'staff_notes' => $notes,
        ]);

        return $letterRequest;
    }

    /**
     * Tahap 3: Persetujuan akhir & TTE oleh Kepala Desa.
     */
    public function approveByKades(LetterRequest $letterRequest, User $kadesUser, ?string $notes = null): LetterRequest
    {
        if ($letterRequest->status !== LetterRequest::STATUS_PENDING_KADES) {
            throw new InvalidArgumentException('Surat belum melewati tahapan verifikasi sebelumnya untuk persetujuan Kades.');
        }

        $letterNumber = $this->generateOfficialLetterNumber($letterRequest);
        $signedAt = Carbon::now();

        $letterRequest->update([
            'status' => LetterRequest::STATUS_APPROVED,
            'letter_number' => $letterNumber,
            'kades_approved_at' => $signedAt,
            'kades_approved_by' => $kadesUser->id,
            'kades_notes' => $notes,
            'signed_at' => $signedAt,
        ]);

        return $letterRequest;
    }

    /**
     * Penolakan permohonan surat di tahapan manapun.
     */
    public function reject(LetterRequest $letterRequest, User $user, string $reason): LetterRequest
    {
        if ($letterRequest->status === LetterRequest::STATUS_APPROVED) {
            throw new InvalidArgumentException('Surat yang sudah disahkan tidak dapat ditolak.');
        }

        $letterRequest->update([
            'status' => LetterRequest::STATUS_REJECTED,
            'rejection_reason' => trim($reason),
            'rejected_by' => $user->id,
            'rejected_at' => Carbon::now(),
        ]);

        return $letterRequest;
    }

    /**
     * Generate format nomor registrasi permohonan (REQ-YYYYMMDD-XXXX).
     */
    public function generateRequestNumber(): string
    {
        $datePrefix = Carbon::now()->format('Ymd');
        $countToday = LetterRequest::whereDate('created_at', Carbon::today())->count() + 1;

        return sprintf('REQ-%s-%04d', $datePrefix, $countToday);
    }

    /**
     * Generate nomor surat resmi (470/{seq}/{code}/Ds/{year}).
     */
    public function generateOfficialLetterNumber(LetterRequest $request): string
    {
        $year = Carbon::now()->format('Y');
        $code = $request->template ? $request->template->code : 'DS';
        $totalApprovedThisYear = LetterRequest::whereYear('signed_at', $year)
            ->whereNotNull('letter_number')
            ->count() + 1;

        return sprintf('470/%03d/%s/Ds/%s', $totalApprovedThisYear, $code, $year);
    }

    /**
     * Parsing dan substitusi seluruh placeholder dalam template surat.
     */
    public function parseTemplateContent(LetterRequest $letterRequest): string
    {
        $template = $letterRequest->template;
        $resident = $letterRequest->resident;
        $family = $resident?->family;

        $content = $template->content_template;

        $replacements = [
            '[NAMA_DESA]' => (string) Setting::get('village_name', 'Sukamaju'),
            '[NAMA_KECAMATAN]' => (string) Setting::get('district_name', 'Cibinong'),
            '[NAMA_KABUPATEN]' => (string) Setting::get('regency_name', 'Bogor'),
            '[NAMA]' => $resident ? $resident->name : '-',
            '[NIK]' => $resident ? $resident->nik : '-',
            '[NO_KK]' => $family ? $family->family_card_number : '-',
            '[TEMPAT_TANGGAL_LAHIR]' => $resident
                ? sprintf('%s, %s', $resident->birth_place, $resident->birth_date ? Carbon::parse($resident->birth_date)->translatedFormat('d F Y') : '-')
                : '-',
            '[JENIS_KELAMIN]' => $resident ? ($resident->gender === 'L' ? 'Laki-laki' : 'Perempuan') : '-',
            '[AGAMA]' => $resident ? ($resident->religion ?? '-') : '-',
            '[STATUS_KAWIN]' => $resident ? ($resident->marital_status ?? '-') : '-',
            '[PENDIDIKAN]' => $resident ? ($resident->education_level ?? '-') : '-',
            '[PEKERJAAN]' => $resident ? ($resident->occupation ?? '-') : '-',
            '[KEWARGANEGARAAN]' => $resident ? ($resident->nationality ?? 'WNI') : 'WNI',
            '[ALAMAT]' => $family ? ($family->address ?? '-') : '-',
            '[RT]' => $family ? ($family->rt ?? '-') : '-',
            '[RW]' => $family ? ($family->rw ?? '-') : '-',
            '[DUSUN]' => $family ? ($family->hamlet ?? '-') : '-',
            '[KEPERLUAN]' => $letterRequest->purpose,
            '[NOMOR_SURAT]' => $letterRequest->letter_number ?? '(Belum Diterbitkan)',
            '[TANGGAL_SURAT]' => Carbon::now()->translatedFormat('d F Y'),
        ];

        // Tambahkan placeholder dari extra_data
        if (is_array($letterRequest->extra_data)) {
            foreach ($letterRequest->extra_data as $key => $val) {
                $placeholder = sprintf('[%s]', strtoupper($key));
                $replacements[$placeholder] = (string) $val;
            }
        }

        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }
}
