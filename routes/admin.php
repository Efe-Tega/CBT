<?php

use App\Http\Controllers\Backend\QuestionsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin,teacher')->group(function () {
    Route::prefix('management')->name('management.')->group(function () {

        // Questions Management
        Route::controller(QuestionsController::class)->group(function () {
            Route::get('/questions', 'manageQuestions')->name('questions');
        });
    });
});
