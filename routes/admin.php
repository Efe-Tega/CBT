<?php

use App\Http\Controllers\Backend\ClassManagement;
use App\Http\Controllers\Backend\QuestionsController;
use App\Http\Controllers\Backend\SchoolManagement;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\StudentManagement;
use App\Http\Controllers\Backend\SubjectManagement;
use App\Http\Controllers\Backend\TeacherManagementController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin,teacher')->group(function () {
    Route::prefix('management')->name('management.')->group(function () {

        // Questions Management
        Route::controller(QuestionsController::class)->group(function () {
            Route::get('/questions', 'manageQuestions')->name('questions');
            Route::get('/questions/{id}', 'questionsPage')->name('questions.page');
            Route::get('/delete/question/{id}', 'deleteQuestion')->name('delete.question');

            Route::post('/subjects/{id}/toggle', 'toggleStatus')->name('subjects.toggle');
            Route::post('/store/question', 'storeQuestion')->name('store.question');
            Route::post('/questions/update/{id}', 'updateQuestion')->name('update.question');
            Route::post('/question/{id}/toggle', 'toggleQuestionVisibility')->name('question.toggle');
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
            Route::post('/update/school_subject', 'updateSchoolSubject')->name('update.school_subject');
        });

        // School Management
        Route::controller(SchoolManagement::class)->group(function () {
            Route::post('/add/school', 'addSchool')->name('add.school');
        });

        // Teacher Management
        Route::controller(TeacherManagementController::class)->group(function () {
            Route::get('/teachers', 'teachers')->name('teachers');
            Route::get('/delete/teacher_data/{id}', 'deleteTeacherData')->name('delete.teacher_data');

            Route::post('/register/teacher', 'registerTeacher')->name('register.teacher');
            Route::post('/teachers/{id}/toggle', 'toggleTeachersStatus');
            Route::post('/update/teacher_data', 'updateTeacherData')->name('update.teacher_data');
        });

        // System Settings
        Route::controller(SettingController::class)->group(function () {
            Route::get('/settings', 'settings')->name('settings');
        });
    });
});
