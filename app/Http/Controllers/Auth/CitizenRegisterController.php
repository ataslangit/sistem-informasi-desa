<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class CitizenRegisterController extends Controller
{
    /**
     * Tampilkan formulir pendaftaran / aktivasi akun mandiri warga.
     */
    public function showRegistrationForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('citizen.letters.index');
        }

        return view('auth.register');
    }

    /**
     * Proses verifikasi data kependudukan dan aktivasi akun warga.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/'],
            'family_card_number' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/'],
            'birth_date' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:25'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
            'consent' => ['required', 'accepted'],
        ], [
            'nik.required' => 'Nomor Induk Kependudukan (NIK) 16 digit wajib diisi.',
            'nik.size' => 'NIK harus tepat 16 digit angka.',
            'family_card_number.required' => 'Nomor Kartu Keluarga (KK) 16 digit wajib diisi.',
            'family_card_number.size' => 'Nomor KK harus tepat 16 digit angka.',
            'birth_date.required' => 'Tanggal lahir sesuai KTP/KK wajib diisi.',
            'email.required' => 'Alamat email aktif wajib diisi.',
            'email.unique' => 'Alamat email ini sudah digunakan oleh akun lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'consent.required' => 'Anda wajib menyetujui pernyataan pemrosesan data pribadi (UU PDP No. 27/2022).',
            'consent.accepted' => 'Persetujuan pemrosesan data pribadi wajib dicentang.',
        ]);

        // 1. Cari data penduduk aktif berdasarkan NIK di Buku Induk Kependudukan
        $resident = Resident::with('family')
            ->where('nik', $validated['nik'])
            ->where('status', 'active')
            ->first();

        if (! $resident) {
            throw ValidationException::withMessages([
                'nik' => 'Data NIK tidak ditemukan sebagai penduduk aktif di desa ini. Silakan hubungi kantor desa.',
            ]);
        }

        // 2. Verifikasi kecocokan tanggal lahir
        $inputBirthDate = Carbon::parse($validated['birth_date'])->format('Y-m-d');
        $residentBirthDate = $resident->birth_date ? $resident->birth_date->format('Y-m-d') : null;

        if ($residentBirthDate !== $inputBirthDate) {
            throw ValidationException::withMessages([
                'birth_date' => 'Tanggal lahir tidak cocok dengan data resmi kependudukan terdaftar.',
            ]);
        }

        // 3. Verifikasi kecocokan nomor Kartu Keluarga (KK)
        $familyCardNumber = $resident->family?->family_card_number;
        if (! $familyCardNumber || $familyCardNumber !== $validated['family_card_number']) {
            throw ValidationException::withMessages([
                'family_card_number' => 'Nomor Kartu Keluarga tidak cocok dengan data anggota keluarga terdaftar.',
            ]);
        }

        // 4. Periksa apakah warga ini sudah memiliki akun layanan mandiri
        $existingUserByNik = User::where('username', $resident->nik)
            ->orWhere('metadata->nik', $resident->nik)
            ->first();

        if ($resident->user_id || $existingUserByNik) {
            throw ValidationException::withMessages([
                'nik' => 'Akun Layanan Mandiri untuk NIK ini sudah pernah diaktifkan. Silakan langsung masuk di halaman login.',
            ]);
        }

        // 5. Buat akun pengguna baru dengan role 'warga'
        $user = User::create([
            'name' => $resident->name,
            'username' => $resident->nik, // Default username adalah NIK 16 digit
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'is_active' => true,
            'metadata' => array_filter([
                'nik' => $resident->nik,
                'no_kk' => $familyCardNumber,
                'phone' => $validated['phone'] ?? null,
                'rt' => $resident->family?->rt,
                'rw' => $resident->family?->rw,
                'pdp_consent' => [
                    'agreed' => true,
                    'agreed_at' => now()->toIso8601String(),
                    'ip' => $request->ip(),
                    'user_agent' => substr((string) $request->userAgent(), 0, 250),
                    'regulation' => 'UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi',
                ],
            ]),
        ]);

        $user->assignRole('warga');

        // 6. Hubungkan akun pengguna ke data penduduk
        $resident->update(['user_id' => $user->id]);

        // 7. Otomatis login dan arahkan ke dashboard layanan mandiri
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('citizen.letters.index')
            ->with('success', "Selamat datang, {$resident->name}! Akun Layanan Mandiri Warga Anda berhasil diaktifkan.");
    }
}
