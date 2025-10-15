<?php

use App\Http\Controllers\Backend\ClassManagement;
use App\Http\Controllers\Backend\QuestionsController;
use App\Http\Controllers\Backend\SchoolManagement;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\StudentManagement;
use App\Http\Controllers\Backend\SubjectManagement;
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

            Route::post('/add/class', 'addClass')->name('add.class');
            Route::put('/update/class', 'updateClass')->name('update.class');
        });

        // Student Management
        Route::controller(StudentManagement::class)->group(function () {
            Route::get('/students/performance', 'studentPerformance')->name('performance');
            Route::get('/student/enrollment', 'studentEnrollment')->name('enrollment');
            Route::delete('/delete/student_data/{id}', 'deleteStudentData')->name('delete.student_data');

            Route::post('/register/student', 'registerStudent')->name('register.student');
            Route::post('/find/students', 'findStudent')->name('find.student');
            Route::post('/update/student_data', 'updateStudentData')->name('update.student_data');
        });

        // Subject Management
        Route::controller(SubjectManagement::class)->group(function () {
            Route::get('/subjects', 'viewSubjects')->name('subjects');

            Route::post('/add/subject', 'addSubject')->name('add.subject');
        });

        // School Management
        Route::controller(SchoolManagement::class)->group(function () {
            Route::post('/add/school', 'addSchool')->name('add.school');
        });

        // System Settings
        Route::controller(SettingController::class)->group(function () {
            Route::get('/settings', 'settings')->name('settings');
        });
    });
});
