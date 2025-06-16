<?php

namespace AppModules\User\Providers;

use AppModules\User\Application\Observers\UserObserver;
use AppModules\User\Domain\Repositories\ProfileRepositoryInterface;
use AppModules\User\Domain\Repositories\UserRepositoryInterface;
use AppModules\User\Infrastructure\Persistence\Models\UserModel;
use AppModules\User\Infrastructure\Persistence\Repositories\EloquentProfileRepository;
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
        $this->app->bind(ProfileRepositoryInterface::class, EloquentProfileRepository::class);


    }

    public function boot(): void
    {
        //
        $this->loadMigrationsFrom(base_path('app-modules/User/Infrastructure/Persistence/Migrations'));
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('app-modules/User/Presentation/Routes/api.php'));
        $this->loadFactories();
        UserModel::observe(UserObserver::class);
    }

    protected function loadFactories(): void
    {
        if ($this->app->runningInConsole()) {
            $factoryPath = base_path('app-modules/User/Infrastructure/Persistence/Factories');
            $this->loadFactoriesFrom($factoryPath);
        }
    }

}
