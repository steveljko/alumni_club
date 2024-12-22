<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\UserLoginController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'login', 'as' => 'login'], function () {
    Route::view('/', 'auth.login');
    Route::post('/', UserLoginController::class)->name('.execute');
});

Route::group(['prefix' => 'forgot_password', 'as' => 'forgot_password'], function () {
    Route::view('/', 'auth.forgot_password');
    Route::put('/', ForgotPasswordController::class)->name('.execute');
});

Route::view('/home', 'home.main')->middleware('auth')->name('home');
