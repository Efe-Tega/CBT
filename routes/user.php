<?php

use App\Http\Controllers\User\StudentExamController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::controller(UserController::class)
        ->group(function () {
            Route::get('/user/dashboard', 'dashboard')->name('user.dashboard');
            Route::get('/user/logout', 'userLogout')->name('user.logout');
            Route::get('/subjects/{id}', 'userQuestions')->name('user.questions');
        });

    Route::controller(StudentExamController::class)->group(function () {
        Route::get('/exam-progress/{examId}', 'getProgress')->name('exam.progress');
        Route::get('/exam/summary', 'examSummary')->name('exam.summary');
        Route::post('/exam/final-submit/', 'finalizeExam')->name('exam.finalize');
        Route::post('/save-answer', 'saveAnswer')->name('save.answer');
    });
});
