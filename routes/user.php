<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('/user/dashboard', 'dashboard')->name('user.dashboard');
        Route::get('/subjects/{id}', 'userQuestions')->name('user.questions');
    });
