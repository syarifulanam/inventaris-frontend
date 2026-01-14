<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/users', [UserController::class, 'index'])->name('users');
