<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\ViewErrorBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an HTTP exception into an HTTP response with multi-theme support.
     */
    protected function renderHttpException(HttpExceptionInterface $e): Response
    {
        $status = $e->getStatusCode();

        try {
            // 1. Jika request dari area admin, cari view error admin atau fallback ke global
            if (request()->is('admin') || request()->is('admin/*')) {
                $adminView = "admin.errors.{$status}";
                if (view()->exists($adminView)) {
                    return response()->view($adminView, [
                        'errors' => new ViewErrorBag,
                        'exception' => $e,
                    ], $status, $e->getHeaders());
                }

                return parent::renderHttpException($e);
            }

            // 2. Resolusi error pada portal publik (Multi-Tema)
            $theme = function_exists('active_theme') ? active_theme() : 'default';

            // Cek di tema yang sedang aktif: themes.{theme}.errors.{status}
            $themeView = "themes.{$theme}.errors.{$status}";
            if (view()->exists($themeView)) {
                return response()->view($themeView, [
                    'errors' => new ViewErrorBag,
                    'exception' => $e,
                ], $status, $e->getHeaders());
            }

            // Cek fallback ke tema default: themes.default.errors.{status}
            $defaultThemeView = "themes.default.errors.{$status}";
            if (view()->exists($defaultThemeView)) {
                return response()->view($defaultThemeView, [
                    'errors' => new ViewErrorBag,
                    'exception' => $e,
                ], $status, $e->getHeaders());
            }
        } catch (\Throwable) {
            // Jika terjadi kesalahan saat resolusi tema, fallback aman ke global
        }

        // 3. Fallback bawaan (resources/views/errors/{status}.blade.php)
        return parent::renderHttpException($e);
    }
}
