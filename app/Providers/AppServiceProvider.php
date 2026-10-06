<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Inisialisasi Zona Waktu Indonesia secara dinamis dari Pengaturan Desa
        try {
            if (Schema::hasTable('settings')) {
                $timezone = (string) Setting::get('timezone', config('app.timezone', 'Asia/Jakarta'));
                if (in_array($timezone, ['Asia/Jakarta', 'Asia/Makassar', 'Asia/Jayapura', 'Asia/Pontianak'], true)) {
                    date_default_timezone_set($timezone);
                    config(['app.timezone' => $timezone]);
                }
            }
        } catch (\Throwable $e) {
            // Fallback jika database belum siap / belum di-migrate
        }
        // Daftarkan View Composer untuk Sidebar Dashboard Admin & Portal Warga
        \Illuminate\Support\Facades\View::composer('admin.layouts.app', \App\Http\ViewComposers\AdminSidebarComposer::class);
    }
}
