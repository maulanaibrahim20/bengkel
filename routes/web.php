<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'home']);
Route::get('/about', [AppController::class, 'about']);
Route::get('/service', [AppController::class, 'service']);
Route::get('/booking', [AppController::class, 'booking']);
Route::get('/contact', [AppController::class, 'contact']);


Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'index']);
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => '/super-admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'admin']);
    });

    Route::group(['prefix' => '/admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'admin']);
    });

    Route::group(['prefix' => '/user'], function () {
        Route::get('/dashboard', [DashboardController::class, 'user']);
    });

    Route::get('/logout', LogoutController::class);
});
