<?php

namespace AppModules\User\Providers;

use AppModules\User\Domain\Repositories\UserRepositoryInterface;
use AppModules\User\Infrastructure\Persistence\Repositories\EloquentUserRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );

    }

    public function boot(): void
    {
        //
        $this->loadMigrationsFrom(base_path('app-modules/User/Infrastructure/Persistence/Migrations'));
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('app-modules/User/Presentation/Routes/api.php'));
    }
}
