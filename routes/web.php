<?php

use App\Http\Controllers\Auth\ManagementLoginController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Backend\ManagementController;
use Illuminate\Support\Facades\Route;

Route::controller(UserLoginController::class)->group(function () {
    Route::get('/login', 'Login');
    Route::post('/login', 'userLogin')->name('login');
});

Route::controller(ManagementLoginController::class)->group(function () {
    Route::get('/management/login', 'managementLogin');
    Route::post('/management/login', 'managementAccess')->name('management.login');
    Route::get('/management/logout', 'managementLogout')->name('management.logout')
        ->middleware('auth:admin,teacher');
});

Route::middleware('auth:admin,teacher')->controller(ManagementController::class)->group(function () {
    Route::get('/management/dashboard', 'dashboard')->name('management.dashboard');
});

require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
