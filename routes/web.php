<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Auth\UserLoginController;
use Illuminate\Support\Facades\Route;

// ---------------- HOME ----------------
Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');

// USER LOGIN
Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserLoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');

// ADMIN LOGIN
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// USER REGISTER
Route::get('/register', [UserLoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserLoginController::class, 'register'])->name('register.submit');


// ---------------- MENU ----------------
Route::get('/menu', [OrderController::class, 'index'])->name('menu.index');

// ---------------- ORDER ROUTES ----------------

// Routes yang butuh login (auth)
Route::middleware(['auth'])->group(function () {

    // Form order
    Route::get('/orders/{product}', [OrderController::class, 'form'])
        ->name('orders.form')
        ->where('product', '[0-9]+');

    // Submit order
    Route::post('/orders', [OrderController::class, 'submit'])
        ->name('orders.submit');

    // Confirmation setelah order selesai
    Route::get('/order/confirmation/{order}', [OrderController::class, 'confirmation'])
        ->name('order.confirmation');
});

// Routes yang tidak butuh login
Route::post('/suggestions', [OrderController::class, 'suggestion'])
    ->name('suggestions.submit');


// ---------------- ADMIN AREA (WITH AUTH) ----------------
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/orders/{order}', [AdminController::class, 'destroyOrder'])->name('admin.orders.destroy');
    Route::resource('products', ProductController::class)->except(['show']);
});