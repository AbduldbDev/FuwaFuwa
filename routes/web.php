<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssetArchiveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetRequestController;
use App\Http\Controllers\MaintenanceRepairController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportAnalyticsController;
use App\Http\Controllers\SystemConfigurationController;
use App\Http\Controllers\VendorController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.store');

    Route::get('/password-reset-first', [AuthController::class, 'showForm'])->name('password.reset.first');
    Route::post('/password-reset-first', [AuthController::class, 'reset'])->name('password.reset.first.post');
});

Route::middleware(['auth', 'UserType:admin,encoder,viewer'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('/')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });

    Route::prefix('/notifications')->name('notifications.')->controller(NotificationController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/read/{id}', 'read')->name('read');
    });

    Route::prefix('/asset')->name('assets.')->controller(AssetController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{id}', 'update')->name('update');
        Route::post('/delete/{id}', 'delete')->name('delete');
        Route::put('/assign', 'assignAsset')->name('assignAsset');
        Route::delete('/delete-document/{document}', 'deletedocument')->name('deletedocument');
        Route::post('/add-document/{asset}',  'addDocument')->name('addDocument');
    });

    Route::prefix('/asset-archive')->name('assets-archive.')->controller(AssetArchiveController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::prefix('/asset-request')->name('asset-request.')->controller(AssetRequestController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
        Route::put('/for-review/{assetRequest}', 'forreview')->name('forreview');





        Route::put('/status/{assetRequest}', 'updateStatus')->name('statusupdate');
        Route::put('/approve/{assetRequest}', 'approveStatus')->name('approveStatus');
        Route::put('/reject/{assetRequest}', 'rejectStatus')->name('rejectStatus');
    });

    Route::prefix('/user-management')->name('user-management.')->controller(AccountController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/create-user', 'store')->name('store');
        Route::put('/update-user/{user}', 'update')->name('update');
        Route::delete('/delete-user/{id}', 'delete')->name('delete');
    });

    Route::prefix('/maintenance-repair')->name('maintenance-repair.')->controller(MaintenanceRepairController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{maintenance}', 'update')->name('update');
        Route::put('/update-corrective/{maintenance}', 'updateCorrective')->name('updateCorrective');
        Route::put('/update-inspection/{maintenance}', 'updateInspection')->name('updateInspection');
        Route::put('/update-inspection-schedule/{maintenance}', 'updateInspectionSchedule')->name('updateInspectionSchedule');
    });

    Route::prefix('/reports')->name('reports-analytics.')->controller(ReportAnalyticsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/download/{id}', 'download')->name('download');
        Route::post('/custom-report', 'generateCustomReport')->name('generateCustomReport');
    });

    Route::prefix('/system-configuration')->name('system-configuration.')->controller(SystemConfigurationController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/update-or-create', 'updateOrCreate')->name('updateOrCreate');
        Route::post('/save-role', 'saveRole')->name('saveRole');
        Route::post('/save-settings', 'saveSettings')->name('saveSettings');
    });

    Route::prefix('/vendors')->name('vendors.')->controller(VendorController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/create-vendor', 'store')->name('store');
        Route::put('/update-vendor/{vendor}', 'update')->name('update');
        Route::post('/delete-vendor/{id}', 'delete')->name('delete');
    });
});
