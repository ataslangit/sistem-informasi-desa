<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Ttpryg\ContentEngine\Contracts\CategoryRepositoryInterface;
use Ttpryg\ContentEngine\Contracts\ContentRepositoryInterface;
use Ttpryg\ContentEngine\Contracts\SlugGeneratorInterface;
use Ttpryg\ContentEngine\Repositories\PdoCategoryRepository;
use Ttpryg\ContentEngine\Repositories\PdoContentRepository;
use Ttpryg\ContentEngine\Services\CategoryService;
use Ttpryg\ContentEngine\Services\ContentService;
use Ttpryg\ContentEngine\Utilities\NativeSlugGenerator;

class ContentEngineServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 1. Bind SlugGenerator
        $this->app->singleton(SlugGeneratorInterface::class, function () {
            return new NativeSlugGenerator;
        });

        // 2. Bind ContentRepository ke PdoContentRepository
        $this->app->singleton(ContentRepositoryInterface::class, function () {
            $pdo = DB::connection()->getPdo();

            return new PdoContentRepository($pdo, 'contents');
        });

        // 3. Bind CategoryRepository ke PdoCategoryRepository
        $this->app->singleton(CategoryRepositoryInterface::class, function () {
            $pdo = DB::connection()->getPdo();

            return new PdoCategoryRepository($pdo, 'categories', 'content_category');
        });

        // 4. Bind ContentService
        $this->app->singleton(ContentService::class, function ($app) {
            return new ContentService(
                contentRepository: $app->make(ContentRepositoryInterface::class),
                slugGenerator: $app->make(SlugGeneratorInterface::class)
            );
        });

        // 5. Bind CategoryService
        $this->app->singleton(CategoryService::class, function ($app) {
            return new CategoryService(
                categoryRepository: $app->make(CategoryRepositoryInterface::class),
                slugGenerator: $app->make(SlugGeneratorInterface::class)
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
