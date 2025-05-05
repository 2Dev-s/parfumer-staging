<?php

use App\Http\Controllers\DefaultPagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DefaultPagesController::class, 'welcome'])->name('welcome');

Route::get('/home/{sex?}', [DefaultPagesController::class, 'home'])->name('home');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
