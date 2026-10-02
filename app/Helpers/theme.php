<?php

declare(strict_types=1);

use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

if (! function_exists('active_theme')) {
    /**
     * Mengambil nama tema publik yang saat ini aktif.
     */
    function active_theme(): string
    {
        try {
            if (Schema::hasTable('settings')) {
                return (string) Setting::get('active_theme', 'default');
            }
        } catch (\Throwable $e) {
            // Fallback saat database belum di-migrate
        }

        return 'default';
    }
}

if (! function_exists('theme_asset')) {
    /**
     * Menghasilkan URL aset statis untuk tema publik.
     */
    function theme_asset(string $path, ?string $theme = null): string
    {
        $selectedTheme = $theme ?: active_theme();
        $cleanPath = ltrim($path, '/');

        return asset("themes/{$selectedTheme}/{$cleanPath}");
    }
}

if (! function_exists('admin_asset')) {
    /**
     * Menghasilkan URL aset statis untuk dashboard admin.
     */
    function admin_asset(string $path): string
    {
        $cleanPath = ltrim($path, '/');

        return asset("assets_admin/{$cleanPath}");
    }
}

if (! function_exists('theme_view')) {
    /**
     * Memuat view Blade dari tema publik yang aktif.
     *
     * @param array<string, mixed> $data
     * @param array<string, mixed> $mergeData
     */
    function theme_view(string $view, array $data = [], array $mergeData = []): View
    {
        $theme = active_theme();
        $viewPath = "themes.{$theme}.{$view}";

        if (! view()->exists($viewPath)) {
            // Fallback ke tema default jika tema aktif tidak memiliki view tersebut
            $fallbackPath = "themes.default.{$view}";
            if (view()->exists($fallbackPath)) {
                return view($fallbackPath, $data, $mergeData);
            }
        }

        return view($viewPath, $data, $mergeData);
    }
}
