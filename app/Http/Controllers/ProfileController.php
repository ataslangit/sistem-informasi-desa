<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan formulir pengaturan profil dan kata sandi akun yang sedang login.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load(['roles', 'resident.family']);

        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Perbarui data profil pengguna (nama, username, email, telepon).
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'max:50', 'unique:users,username,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:25'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Nama pengguna (username) wajib diisi.',
            'username.alpha_dash' => 'Username hanya boleh berisi kombinasi huruf, angka, tanda strip, dan garis bawah.',
            'username.unique' => 'Username tersebut sudah digunakan oleh akun lain.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email tersebut sudah terdaftar di sistem.',
        ]);

        $metadata = $user->metadata ?? [];
        if (! empty($validated['phone'])) {
            $metadata['phone'] = $validated['phone'];
        } else {
            unset($metadata['phone']);
        }

        $user->update([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'metadata' => ! empty($metadata) ? $metadata : null,
        ]);

        return back()->with('success', 'Informasi profil akun Anda berhasil diperbarui.');
    }

    /**
     * Ubah kata sandi akun pengguna.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Kata sandi akun Anda berhasil diperbarui.');
    }
}
