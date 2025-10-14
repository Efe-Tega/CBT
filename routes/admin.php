<?php

use App\Http\Controllers\Backend\ClassManagement;
use App\Http\Controllers\Backend\QuestionsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin,teacher')->group(function () {
    Route::prefix('management')->name('management.')->group(function () {

        // Questions Management
        Route::controller(QuestionsController::class)->group(function () {
            Route::get('/questions', 'manageQuestions')->name('questions');
        });

        // Class Management
        Route::controller(ClassManagement::class)->group(function () {
            Route::get('/classes', 'viewClasses')->name('classes');
        });
    });
});
