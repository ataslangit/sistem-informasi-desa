<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('admin.auth.login');
    }

    /**
     * Memproses otentikasi login pengguna (mendukung email dan username).
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Kolom email atau username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginInput = $credentials['login'];
        $loginField = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Cek status aktif user sebelum autentikasi
        $user = User::where($loginField, $loginInput)->first();
        if ($user && ! $user->is_active) {
            throw ValidationException::withMessages([
                'login' => 'Akun Anda berstatus nonaktif. Silakan hubungi administrator desa.',
            ]);
        }

        $remember = $request->boolean('remember');

        if (Auth::attempt([$loginField => $loginInput, 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            /** @var User $authenticatedUser */
            $authenticatedUser = Auth::user();

            return $this->redirectBasedOnRole($authenticatedUser)
                ->with('success', 'Selamat datang kembali, '.$authenticatedUser->name.'!');
        }

        throw ValidationException::withMessages([
            'login' => 'Email/username atau kata sandi yang Anda masukkan salah.',
        ]);
    }

    /**
     * Mengarahkan pengguna setelah berhasil login berdasarkan role yang dimiliki.
     */
    protected function redirectBasedOnRole(User $user): RedirectResponse
    {
        if ($user->hasRole(['superadmin', 'kades', 'perangkat'])) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->hasRole('rt')) {
            return redirect()->intended(route('admin.letter-requests.index'));
        }

        if ($user->hasRole('warga')) {
            return redirect()->intended(route('citizen.letters.index'));
        }

        return redirect()->intended(route('home'));
    }

    /**
     * Logout pengguna dari sesi saat ini.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
