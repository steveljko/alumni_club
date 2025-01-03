<?php

use App\Http\Controllers\Auth\ChangeInitialPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SetDetailsController;
use App\Http\Controllers\Auth\ShowResetPasswordController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Work\AddWorkController;
use App\Http\Controllers\Work\PublishWorkHistoryController;
use App\Http\Controllers\Work\ShowWorkHistoryController;
use App\Http\Middleware\AccountSetupCompleted;
use App\Http\Middleware\CanAccessSetupStep;
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
        'middleware' => 'auth',
    ], function () {
        Route::group(['prefix' => '/step/1', 'as' => 'step.1', 'middleware' => CanAccessSetupStep::class.':1'], function () {
            Route::view('/', 'auth.setup.initial_password_change');
            Route::put('/', ChangeInitialPasswordController::class);
        });

        Route::group(['prefix' => '/step/2', 'as' => 'step.2', 'middleware' => CanAccessSetupStep::class.':2'], function () {
            Route::view('/', 'auth.setup.add_details');
            Route::put('/', SetDetailsController::class);
        });

        Route::group(['prefix' => '/step/3', 'as' => 'step.3', 'middleware' => CanAccessSetupStep::class.':3'], function () {
            Route::get('/', ShowWorkHistoryController::class);
            Route::post('/add_work', AddWorkController::class)->name('.add_work');
            Route::patch('/', PublishWorkHistoryController::class);
        });
    });
});

Route::view('/home', 'home.main')
    ->middleware(['auth', AccountSetupCompleted::class])
    ->name('home');
