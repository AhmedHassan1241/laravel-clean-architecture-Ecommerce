<?php

namespace AppModules\Cart\Providers;

use AppModules\Cart\Domain\Repositories\CartRepositoryInterface;
use AppModules\Cart\Infrastructure\Persistence\Repositories\EloquentCartRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CartRepositoryInterface::class,
            EloquentCartRepository::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(base_path('app-modules\Cart\Infrastructure\Persistence\Migrations'));
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('app-modules/Cart/Presentation/Routes/api.php'));

    }
}
