<?php

namespace AppModules\Category\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->loadMigrationsFrom(base_path('app-modules/Category/Infrastructure/Persistence/Migrations'));
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('app-modules/Category/Presentation/Routes/api.php'));

    }
}
