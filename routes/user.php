<?php

use App\Http\Controllers\User\StudentExamController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::controller(UserController::class)
        ->group(function () {
            Route::get('/user/dashboard', 'dashboard')->name('user.dashboard');
            Route::get('/subjects/{id}', 'userQuestions')->name('user.questions');
        });

    Route::controller(StudentExamController::class)->group(function () {
        Route::post('/save-answer', 'saveAnswer')->name('save.answer');
    });
});
