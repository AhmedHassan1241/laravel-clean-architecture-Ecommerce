<?php

use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsCustomer;
use App\Http\Middleware\IsDelivery;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(


    // if two work then route should be:
    //for api  ex : http://127.0.0.1:8000/api/auth/login
    //for web  ex : http://127.0.0.1:8000/web/auth/login

//        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        apiPrefix: '/',

    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            "IsAdmin" => IsAdmin::class,
            "IsCustomer" => IsCustomer::class,
            "IsDelivery" => IsDelivery::class,
            'permission' => CheckPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //

    })
    ->create();
