<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Cms\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\BrandEngineController;
use App\Http\Controllers\Master\ProductCategoryController;
use App\Http\Controllers\Master\TechnicianController;
use Illuminate\Support\Facades\Route;




Route::middleware(['guest'])->group(function () {

    Route::get('/', [AppController::class, 'home']);
    Route::get('/about', [AppController::class, 'about']);
    Route::get('/service', [AppController::class, 'service']);
    Route::get('/booking', [AppController::class, 'booking']);
    Route::get('/contact', [AppController::class, 'contact']);


    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'index']);
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'super-admin', 'middleware' => 'can:super-admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'admin']);

        Route::group(['prefix' => 'cms'], function () {
            Route::get('cms/pages/datatables', [PageController::class, 'getDatatable'])->name('pages.cms.datatable');
            Route::resource('pages', PageController::class);
        });

        Route::prefix('master')->group(function () {
            Route::group(['prefix' => 'brand-engine', 'controller' => BrandEngineController::class], function () {
                Route::get('/datatable', [BrandEngineController::class, 'getDataTable']);
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}/update', 'update');
                Route::delete('/{id}/delete', 'destroy');
            });

            Route::group(['prefix' => 'technician', 'controller' => TechnicianController::class], function () {
                Route::get('/datatable', [TechnicianController::class, 'getDataTable']);
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}/update', 'update');
                Route::delete('/{id}/delete', 'destroy');
                Route::get('/check-username', 'checkUsername');
            });

            Route::group(['prefix' => 'product-category', 'controller' => ProductCategoryController::class], function () {
                Route::get('/datatable', [ProductCategoryController::class, 'getDataTable']);
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}/update', 'update');
                Route::delete('/{id}/delete', 'destroy');
            });
        });
    });

    Route::group(['prefix' => '/admin', 'middleware' => 'can:admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'admin']);
    });

    Route::group(['prefix' => '/user', 'middleware' => 'can:user'], function () {
        Route::get('/dashboard', [DashboardController::class, 'user']);
    });

    Route::get('/logout', LogoutController::class);
});
