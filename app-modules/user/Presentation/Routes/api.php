<?php

use AppModules\User\Presentation\Controllers\AuthController;
use AppModules\User\Presentation\Controllers\ProfileController;
use AppModules\User\Presentation\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    //=================================================================//
});

Route::prefix('profile')->middleware('auth:sanctum')->group(function () {
//    Route::post('', [ProfileController::class, 'store']); //done
    Route::get('', [ProfileController::class, 'show']); //done
    Route::post('update', [ProfileController::class, 'update']); //done
//    Route::delete('/{id}', [ProfileController::class, 'destroy']); //done
});

// admin only can access to this routes
Route::prefix('admin/user')->middleware(['auth:sanctum', 'IsAdmin'])->group(function () {
    Route::get('all', [UserController::class, 'index']);
    Route::delete('{id}', [UserController::class, 'delete']);
    Route::put('{id}', [UserController::class, 'update']);
    Route::get('{id}', [UserController::class, 'show']);
});

//Route::prefix('customer/user')->middleware(['auth:sanctum', 'IsCustomer'])->group(function () {
//    Route::get('{id}', [UserController::class, 'show']);
//});


// for user
Route::prefix('user')->group(function () {
    // Add any normal user routes here if needed in the future
});


Route::prefix('user')->middleware('auth:sanctum')->group(function () {
});
