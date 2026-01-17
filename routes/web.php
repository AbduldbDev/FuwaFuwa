<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.store');

    Route::get('/password-reset-first', [LoginController::class, 'showForm'])->name('password.reset.first');
    Route::post('/password-reset-first', [LoginController::class, 'reset'])->name('password.reset.first.post');
});


Route::middleware(['auth', 'UserType:admin,encoder'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('/')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });


    Route::prefix('/asset')->name('asset.')->controller(AssetController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
    });

    Route::prefix('/user-management')->name('user-management.')->controller(AccountController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/create-user', 'store')->name('store');
        Route::put('/update-user/{id}', 'update')->name('update');
        Route::delete('/delete-user/{id}', 'delete')->name('delete');
    });


    Route::prefix('/maintenance-repair')->name('maintenance-repair.')->group(function () {
        Route::get('/', function () {
            return view('Pages/maintenance');
        });
    });


    Route::prefix('/reports-analytics')->name('reports-analytics.')->group(function () {
        Route::get('/', function () {
            return view('Pages/reports');
        });
    });

    Route::prefix('/system-configuration')->name('system-configuration.')->group(function () {
        Route::get('/', function () {
            return view('Pages/system');
        });
    });
});
