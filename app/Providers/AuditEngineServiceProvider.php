<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Ttpryg\AuditEngine\Application\Service\AuditService;
use Ttpryg\AuditEngine\Domain\Repository\AuditRepositoryInterface;
use Ttpryg\AuditEngine\Infrastructure\Persistence\Pdo\PdoAuditStorage;

class AuditEngineServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind AuditRepositoryInterface ke PdoAuditStorage
        $this->app->singleton(AuditRepositoryInterface::class, function () {
            $pdo = DB::connection()->getPdo();

            return new PdoAuditStorage($pdo, 'audit_logs');
        });

        // Bind AuditService
        $this->app->singleton(AuditService::class, function ($app) {
            return new AuditService(
                $app->make(AuditRepositoryInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
