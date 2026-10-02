<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('login'));
        }

        if (! $user->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda dinonaktifkan. Silakan hubungi administrator.',
            ]);
        }

        // Cek apakah user memiliki salah satu dari role yang diizinkan
        if (! empty($roles) && ! $user->hasRole($roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki hak akses yang memadai untuk membuka halaman ini.');
        }

        return $next($request);
    }
}
