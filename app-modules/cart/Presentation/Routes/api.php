<?php

namespace AppModules\Cart\Presentation\Routes;


//for all
use AppModules\cart\Presentation\Controllers\CartController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->prefix('carts/')->group(function () {
    Route::post('add', [CartController::class, 'addToCart']);
    Route::post('decrease', [CartController::class, 'decreaseQuantity']);
    Route::post('', [CartController::class, 'removeFromCart']);
    Route::get('', [CartController::class, 'viewCart']);
});

// Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
// Route::get('/cart/{cart}', [CartController::class, 'show'])->name('cart.show');
// Route::get('/cart/{cart}/edit', [CartController::class, 'edit'])->name('cart.edit');
// Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
// Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
