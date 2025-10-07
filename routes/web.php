<?php

use App\Http\Controllers\Auth\UserLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.user-login');
});

Route::controller(UserLoginController::class)->group(function(){
    Route::get('/login', 'Login');
    Route::post('/login', 'userLogin')->name('login');
});

require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
