<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::post('/products/{id}/sell', [ProductController::class, 'sell'])->name('products.sell');
Route::get('/products/{id}/sell/create', [ProductController::class, 'sellCreate'])->name('products.sell.create');

Route::get('/users', [UserController::class, 'index'])->name('users');
