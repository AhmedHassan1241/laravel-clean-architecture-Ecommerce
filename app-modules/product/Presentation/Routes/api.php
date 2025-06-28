<?php

use AppModules\Product\Presentation\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


// for admin
Route::middleware(['auth:sanctum', 'IsAdmin'])->group(function () {
    Route::delete('products/undelete/{id}', [ProductController::class, 'undoDelete']);
    Route::delete('products/permanentdelete/{id}', [ProductController::class, 'permanentDelete']);
    Route::get('products/index/admin', [ProductController::class, 'indexAdmin']);

});


//for all
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/filter', [ProductController::class, 'filter']);
Route::get('/products/featured', [ProductController::class, 'featured']);

//for all
Route::apiResource('products', ProductController::class)
    ->only(['index', 'show'])
    ->parameters(['products' => 'id']);


Route::middleware(['auth:sanctum'])->group(function () {
//    Route::middleware(['auth:sanctum', 'permission:create products'])->group(function () {

    Route::apiResource('products', ProductController::class)
        ->parameters(['products' => 'id'
            // /id instead of /product
        ])->except(['index', 'show']);
});



// Route::post('/products', [ProductController::class, 'store'])->name('products.store');
// Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
// Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
// Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
// Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
