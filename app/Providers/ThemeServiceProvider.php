<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Memuat helper tema
        if (file_exists(app_path('Helpers/theme.php'))) {
            require_once app_path('Helpers/theme.php');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan variabel tema aktif ke seluruh view Blade
        View::composer('*', function ($view) {
            $activeTheme = active_theme();
            $view->with('activeTheme', $activeTheme);
        });
    }
}
