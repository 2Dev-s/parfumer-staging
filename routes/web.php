<?php

use App\Http\Controllers\DefaultPagesController;
use App\Http\Controllers\ParfumesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DefaultPagesController::class, 'welcome'])->name('welcome');

Route::get('/home/{sex?}', [DefaultPagesController::class, 'home'])->name('home');
Route::get('/parfumuri', [ParfumesController::class, 'index'])->name('parfumes');
Route::post('/parfumuri', [ParfumesController::class, 'index'])->name('parfumes');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
