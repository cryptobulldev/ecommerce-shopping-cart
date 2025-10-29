<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🛍️ Shop module
    Route::prefix('shop')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('shop.products.index');

        Route::get('/cart', [CartController::class, 'index'])->name('shop.cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('shop.cart.store');
        Route::patch('/cart/{id}', [CartController::class, 'update'])->name('shop.cart.update');
        Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('shop.cart.destroy');

        Route::post('/checkout', [OrderController::class, 'store'])->name('shop.checkout.store');
    });

});

require __DIR__.'/auth.php';
