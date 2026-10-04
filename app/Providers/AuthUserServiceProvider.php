<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Ttpryg\AuthUser\Contracts\RbacRepositoryInterface;
use Ttpryg\AuthUser\Contracts\TokenRepositoryInterface;
use Ttpryg\AuthUser\Contracts\UserRepositoryInterface;
use Ttpryg\AuthUser\Repositories\PdoRbacRepository;
use Ttpryg\AuthUser\Repositories\PdoTokenRepository;
use Ttpryg\AuthUser\Repositories\PdoUserRepository;
use Ttpryg\AuthUser\Services\RbacManager;

class AuthUserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind RbacRepositoryInterface
        $this->app->singleton(RbacRepositoryInterface::class, function () {
            $pdo = DB::connection()->getPdo();

            return new PdoRbacRepository($pdo);
        });

        // Bind UserRepositoryInterface
        $this->app->singleton(UserRepositoryInterface::class, function () {
            $pdo = DB::connection()->getPdo();

            return new PdoUserRepository($pdo);
        });

        // Bind TokenRepositoryInterface
        $this->app->singleton(TokenRepositoryInterface::class, function () {
            $pdo = DB::connection()->getPdo();

            return new PdoTokenRepository($pdo);
        });

        // Bind RbacManager
        $this->app->singleton(RbacManager::class, function ($app) {
            return new RbacManager(
                $app->make(RbacRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class)
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
