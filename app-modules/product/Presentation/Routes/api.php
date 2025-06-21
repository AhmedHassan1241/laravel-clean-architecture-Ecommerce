<?php

use AppModules\Product\Presentation\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/products/search', [ProductController::class, 'search']);
Route::apiResource('products', ProductController::class)->only(['index', 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
//    Route::middleware(['auth:sanctum', 'permission:create products'])->group(function () {

    Route::apiResource('products', ProductController::class)->parameters([
        'products' => 'id'
        // /id instead of /product
    ])->except(['index', 'show']);
});



// Route::post('/products', [ProductController::class, 'store'])->name('products.store');
// Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
// Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
// Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
// Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
