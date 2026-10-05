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

if (! function_exists('theme_layout')) {
    /**
     * Mengambil path layout master utama untuk tema publik yang aktif.
     */
    function theme_layout(): string
    {
        $theme = active_theme();
        if (view()->exists("themes.{$theme}.layouts.app")) {
            return "themes.{$theme}.layouts.app";
        }

        return 'themes.default.layouts.app';
    }
}

if (! function_exists('theme_view')) {
    /**
     * Memuat view Blade dari tema publik yang aktif.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $mergeData
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

if (! function_exists('public_header_menus')) {
    /**
     * Mengambil struktur menu navigasi header publik yang aktif.
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Menu>
     */
    function public_header_menus(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('menus')) {
                return \App\Models\Menu::header()
                    ->root()
                    ->active()
                    ->with(['children' => fn ($q) => $q->active()->orderBy('sort_order'), 'page'])
                    ->orderBy('sort_order')
                    ->get();
            }
        } catch (\Throwable $e) {
            // Fallback saat database belum di-migrate
        }

        return new \Illuminate\Database\Eloquent\Collection;
    }
}
