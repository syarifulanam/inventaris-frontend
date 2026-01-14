<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/products', [ProdukController::class, 'index'])->name('products');
Route::get('/users', [UserController::class, 'index'])->name('users');
