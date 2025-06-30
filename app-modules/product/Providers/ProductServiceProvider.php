<?php

namespace AppModules\Product\Providers;

use AppModules\Cart\Infrastructure\Repositories\EloquentCartRepository;
use AppModules\Product\Domain\Repositories\ProductRepositoryInterface;
use AppModules\product\Infrastructure\Persistence\Repositories\EloquentProductRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            EloquentProductRepository::class);

    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(base_path('app-modules/Product/Infrastructure/Persistence/Migrations'));
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('app-modules/Product/Presentation/Routes/api.php'));
    }
}
