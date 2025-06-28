<?php

namespace AppModules\Category\Presentation\Routes;


use AppModules\Category\Presentation\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


//Route::prefix('categories')->group(function () {
//    Route::get('/', [CategoryController::class, 'index']);
//    Route::get('/{id}', [CategoryController::class, 'show']);
//});

Route::get('categories/{id}/products', [CategoryController::class, 'products']);
Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show'])
    ->parameters(['categories' => 'id']);
Route::middleware(['auth:sanctum'])->group(function () {
//    Route::middleware(['auth:sanctum', 'permission:create categories'])->group(function () {

    Route::apiResource('categories', CategoryController::class)->except(['index', 'show'])->parameters(['categories' => 'id']);
});

// Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
// Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
// Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
// Route::get('/categories/{categoryServiceProvider}', [CategoryController::class, 'show'])->name('categories.show');
// Route::get('/categories/{categoryServiceProvider}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
// Route::put('/categories/{categoryServiceProvider}', [CategoryController::class, 'update'])->name('categories.update');
// Route::delete('/categories/{categoryServiceProvider}', [CategoryController::class, 'destroy'])->name('categories.destroy');
