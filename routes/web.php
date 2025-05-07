<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DefaultPagesController;
use App\Http\Controllers\ParfumesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DefaultPagesController::class, 'welcome'])->name('welcome');

Route::get('/acasa/{sex?}', [DefaultPagesController::class, 'home'])->name('home');
Route::match(['get', 'post'], '/parfumuri', [ParfumesController::class, 'index'])->name('parfumes');
Route::get('/parfum/{parfum:slug}', [ParfumesController::class, 'show'])->name('parfums.show');

Route::prefix('cos')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::get('/vizualizare', [CartController::class, 'view'])->name('cart.view');
    Route::post('/adauga/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/actualizeaza/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/sterge/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/goleste', [CartController::class, 'clear'])->name('cart.clear');
});

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout')->middleware('auth');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
