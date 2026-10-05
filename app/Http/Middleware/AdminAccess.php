<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Memastikan akses area admin hanya untuk Superadmin, Kepala Desa, dan Perangkat Desa.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('login'));
        }

        if (! $user->is_active) {
            auth()->logout();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda dinonaktifkan oleh administrator.',
            ]);
        }

        // Hanya role staf/pengelola desa dan RT yang diizinkan masuk ke dashboard admin
        $adminRoles = ['superadmin', 'kades', 'perangkat', 'rt'];

        if (! $user->hasRole($adminRoles)) {
            abort(403, 'Akses terbatas. Halaman dashboard admin hanya diperuntukkan bagi aparatur desa dan administrator.');
        }

        return $next($request);
    }
}
