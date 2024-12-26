<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ShowResetPasswordController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Middleware\FirstTimeLoginMiddleware;
use Illuminate\Support\Facades\Route;

Route::as('auth.')->group(function () {
    Route::group(['prefix' => 'login', 'as' => 'login'], function () {
        Route::view('/', 'auth.login');
        Route::post('/', UserLoginController::class)->name('.execute');
    });

    Route::group(['prefix' => '/password', 'as' => 'password.'], function () {
        Route::group(['prefix' => '/forgot', 'as' => 'forgot'], function () {
            Route::view('/', 'auth.forgot_password');
            Route::put('/', ForgotPasswordController::class)->name('.execute');
        });

        Route::group(['prefix' => '/reset', 'as' => 'reset'], function () {
            Route::get('/{token}', ShowResetPasswordController::class);
            Route::put('/{token}', ResetPasswordController::class)->name('.execute');
        });
    });

    Route::group([
        'prefix' => '/setup',
        'as' => 'setup.',
        'middleware' => ['auth'],
    ], function () {
        Route::group([
            'prefix' => '/initial-password-change',
            'as' => 'initial_password_change',
            'middleware' => FirstTimeLoginMiddleware::class,
        ], function () {
            Route::view('/', 'auth.initial_password_change');
            Route::put('/', ChangePasswordController::class)->name('.execute');
        });
    });
});

Route::view('/home', 'home.main')->middleware('auth', FirstTimeLoginMiddleware::class)->name('home');
