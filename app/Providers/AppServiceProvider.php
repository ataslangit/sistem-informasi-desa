<?php

namespace App\Providers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Content;
use App\Models\PublicDocument;
use App\Models\Setting;
use App\Services\SitemapService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Pastikan file .env tersedia dari .env.example jika belum ada
        $envPath = base_path('.env');
        if (! file_exists($envPath)) {
            $examplePath = base_path('.env.example');
            if (file_exists($examplePath)) {
                copy($examplePath, $envPath);
            }
        }

        // Pastikan APP_KEY tidak kosong agar EncryptCookies dan sesi installer berjalan normal tanpa error 500
        if (empty(config('app.key'))) {
            $key = 'base64:'.base64_encode(\Illuminate\Support\Str::random(32));
            config(['app.key' => $key]);

            if (file_exists($envPath) && is_writable($envPath)) {
                $content = file_get_contents($envPath);
                if (preg_match('/^APP_KEY=.*/m', $content)) {
                    $content = preg_replace('/^APP_KEY=.*/m', "APP_KEY={$key}", $content);
                } else {
                    $content .= "\nAPP_KEY={$key}";
                }
                file_put_contents($envPath, $content);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Inisialisasi Zona Waktu Indonesia secara dinamis dari Pengaturan Desa jika sistem sudah diinstal
        if (\App\Services\InstallerService::isInstalled()) {
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
        }

        // Daftarkan View Composer untuk Sidebar Dashboard Admin & Portal Warga
        \Illuminate\Support\Facades\View::composer('admin.layouts.app', \App\Http\ViewComposers\AdminSidebarComposer::class);

        $this->registerSitemapCacheInvalidation();
    }

    /**
     * Bersihkan cache sitemap setiap kali konten publik berubah.
     */
    private function registerSitemapCacheInvalidation(): void
    {
        $invalidate = static function (): void {
            Cache::forget(SitemapService::CACHE_KEY);
        };

        foreach ([Content::class, Category::class, Budget::class, PublicDocument::class] as $model) {
            $model::saved($invalidate);
            $model::deleted($invalidate);
        }

        Content::restored($invalidate);
        PublicDocument::restored($invalidate);
    }
}
