<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\InstallerService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfInstalled
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (InstallerService::isInstalled()) {
            return redirect('/');
        }

        return $next($request);
    }
}
