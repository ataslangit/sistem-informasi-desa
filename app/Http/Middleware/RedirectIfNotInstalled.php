<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\InstallerService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotInstalled
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! InstallerService::isInstalled()) {
            if (! $request->is('install*')) {
                return redirect()->route('installer.index');
            }
        }

        return $next($request);
    }
}
