<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AppKasirController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BookingSlotSuperAdminController;
use App\Http\Controllers\CheckBookingController;
use App\Http\Controllers\Cms\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\BrandEngineController;
use App\Http\Controllers\Master\ProductCategoryController;
use App\Http\Controllers\Master\ProductUnitController;
use App\Http\Controllers\Master\TechnicianController;
use App\Http\Controllers\MotorCycleAdminController;
use App\Http\Controllers\MotorCycleUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\UserBookingHistoryController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserSuperAdminController;
use Illuminate\Support\Facades\Route;




Route::middleware(['guest'])->group(function () {

    Route::get('/', [AppController::class, 'home']);
    Route::get('/about', [AppController::class, 'about']);
    Route::get('/service', [AppController::class, 'service']);

    Route::get('/booking', [AppController::class, 'booking']);
    Route::get('/booking/register', [AppController::class, 'bookingRegister']);

    Route::get('/contact', [AppController::class, 'contact']);

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'index']);
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/auth/{provider}/redirect', [RegisterController::class, 'redirectToProvider']);

    Route::get('/verify-email/{token}', [RegisterController::class, 'verifyEmail']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'index']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendEmail']);

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::get('/auth/{provider}/callback', [RegisterController::class, 'register']);


Route::middleware(['auth'])->group(function () {

    Route::get('/check-booking/{booking_code}', [CheckBookingController::class, 'handle']);
    Route::put('/check-booking/{booking_code}', [CheckBookingController::class, 'updateMotorDetails']);

    Route::group(['prefix' => 'super-admin', 'middleware' => 'can:super-admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'superAdmin']);

        Route::group(['prefix' => 'product', 'controller' => ProductController::class], function () {
            Route::get('/datatable', 'getDataTable');
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::post('/create', 'store');
            Route::get('/{id}/edit', 'edit');
            Route::put('/{id}/update', 'update');
            Route::delete('/{id}/delete', 'destroy');
        });

        Route::group(['prefix' => 'service', 'controller' => ServiceController::class], function () {
            Route::get('/datatable', 'getDataTable');
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::post('/create', 'store');
            Route::get('/{id}/details', 'getDetails');
            Route::get('/{id}/edit', 'edit');
            Route::put('/{id}/update', 'update');
            Route::delete('/{id}/delete', 'destroy');
        });

        Route::prefix('master')->group(function () {
            Route::group(['prefix' => 'brand-engine', 'controller' => BrandEngineController::class], function () {
                Route::get('/datatable', 'getDataTable');
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}/update', 'update');
                Route::delete('/{id}/delete', 'destroy');
            });

            Route::group(['prefix' => 'technician', 'controller' => TechnicianController::class], function () {
                Route::get('/datatable', 'getDataTable');
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}/update', 'update');
                Route::delete('/{id}/delete', 'destroy');
                Route::get('/check-username', 'checkUsername');
            });

            Route::group(['prefix' => 'product-category', 'controller' => ProductCategoryController::class], function () {
                Route::get('/datatable', 'getDataTable');
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}/update', 'update');
                Route::delete('/{id}/delete', 'destroy');
            });

            Route::group(['prefix' => 'product-unit', 'controller' => ProductUnitController::class], function () {
                Route::get('/datatable', 'getDataTable');
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}/update', 'update');
                Route::delete('/{id}/delete', 'destroy');
            });
        });

        Route::group(['prefix' => 'motorcycle', 'controller' => MotorCycleAdminController::class], function () {
            Route::get('/datatable', 'getDataTable');
            Route::get('/', 'index');
        });

        Route::group(['prefix' => 'user', 'controller' => UserSuperAdminController::class], function () {
            Route::get('/datatable', 'getDataTable');
            Route::get('/', 'index');
            Route::post('/create', 'store');
            Route::get('/{id}/edit', 'edit');
            Route::put('/{id}/update', 'update');
            Route::delete('/{id}/delete', 'destroy');
            Route::post('/{id}/change-status', 'changeStatus');
        });

        Route::group(['prefix' => 'booking-slot', 'controller' => BookingSlotSuperAdminController::class], function () {
            Route::get('/datatable', 'getDataTable');
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::post('/create', 'store');
            Route::put('/{id}/update', 'update');
            Route::delete('/{id}/delete', 'destroy');
            Route::get('/details-booking/{date}', 'showSlotDetailPage');
            Route::post('/generate', 'generate');
        });
    });

    Route::get('/app/kasir/getData', [AppKasirController::class, 'getData']);
    Route::get('/app/kasir', [AppKasirController::class, 'index']);

    Route::group(['prefix' => 'admin', 'middleware' => 'can:admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'admin']);

        // Route::group(['prefix' => 'motorcycle', 'controller' => MotorCycleAdminController::class], function () {
        //     Route::get('/datatable', 'getDataTable');
        //     Route::get('/', 'index');
        //     Route::post('/create', 'store');
        //     Route::get('/{id}/edit', 'edit');
        //     Route::put('/{id}/update', 'update');
        //     Route::delete('/{id}/delete', 'destroy');
        // });
    });

    Route::group(['prefix' => 'user', 'middleware' => 'can:user'], function () {
        Route::get('/dashboard', [DashboardController::class, 'user']);

        Route::get('/welcome', function () {
            return view('user.pages.welcome');
        });

        Route::group(['prefix' => 'booking', 'controller' => UserBookingController::class], function () {
            Route::get('/slot/{date}', 'getSlots');
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::post('/create', 'store');
            Route::get('/{id}/qrcode', 'showQrCode')->name('user.booking.qrcode');
        });

        Route::group(['prefix' => 'booking-history', 'controller' => UserBookingHistoryController::class], function () {
            Route::get('/datatable', 'getDataTable');
            Route::get('/', 'index');
            Route::get('/{id}/details', 'show');
            Route::post('/{id}/status', 'updateStatus');
            Route::put('/{id}/cancel', 'cancel');
            Route::get('/{booking_code}/qr-view', 'qrView');
        });

        Route::group(['prefix' => 'motorcycle', 'controller' => MotorCycleUserController::class], function () {
            Route::get('/datatable', 'getDataTable');
            Route::get('/', 'index');
            Route::post('/create', 'store');
            Route::get('/{id}/edit', 'edit');
            Route::put('/{id}/update', 'update');
            Route::delete('/{id}/delete', 'destroy');
        });



        Route::get('/update/profile', [UserProfileController::class, 'formRegister']);
        Route::put('/update/profile', [UserProfileController::class, 'update']);
    });

    Route::get('{role}/profile', [ProfileController::class, 'index']);
    Route::get('{role}/profile/{id}/edit', [ProfileController::class, 'edit']);
    Route::put('{role}/profile/update', [ProfileController::class, 'update']);


    Route::get('/logout', LogoutController::class)->name('logout');
});
