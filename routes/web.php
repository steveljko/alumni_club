<?php

use App\Http\Actions\Auth\UserLogout;
use App\Http\Actions\Profile\ShowProfileController;
use App\Http\Controllers\Auth\ChangeInitialPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetAvatarController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SetAvatarController;
use App\Http\Controllers\Auth\SetDetailsController;
use App\Http\Controllers\Auth\ShowAccountSettingsController;
use App\Http\Controllers\Auth\ShowAddWorkHistoryStepController;
use App\Http\Controllers\Auth\ShowResetPasswordController;
use App\Http\Controllers\Auth\UpdateUserController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Home\ShowHomeController;
use App\Http\Controllers\Post\CreatePostController;
use App\Http\Controllers\Post\GetPostFormController;
use App\Http\Controllers\WorkHistory\CreateWorkHistoryController;
use App\Http\Controllers\WorkHistory\DeleteWorkHistoryController;
use App\Http\Controllers\WorkHistory\EditWorkHistoryController;
use App\Http\Controllers\WorkHistory\PublishWorkHistoryController;
use App\Http\Controllers\WorkHistory\ShowWorkHistoryController;
use App\Http\Controllers\WorkHistory\SkipAddingWorkHistoryController;
use App\Http\Controllers\WorkHistory\UpdateWorkHistoryController;
use App\Http\Middleware\AccountSetupCompleted;
use App\Http\Middleware\CanAccessSetupStep;
use Illuminate\Support\Facades\Route;

Route::as('auth.')->group(function () {
    Route::group(['prefix' => 'login', 'as' => 'login'], function () {
        Route::view('/', 'auth.login');
        Route::post('/', UserLoginController::class)->name('.execute');
    });

    Route::delete('/logout', UserLogout::class)->middleware('auth')->name('logout');

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
            Route::get('/', ShowAddWorkHistoryStepController::class);
            Route::patch('/skip', SkipAddingWorkHistoryController::class)->name('.skip');
        });
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings', 'middleware' => 'auth'], function () {
        Route::get('/', ShowAccountSettingsController::class);
        Route::put('/update', UpdateUserController::class)->name('.update');
        Route::post('/avatar', SetAvatarController::class)->name('.avatar');
        Route::patch('/avatar/reset', ResetAvatarController::class)->name('.avatarReset');
        Route::patch('/password', ChangePasswordController::class)->name('.changePassword');
    });
});

Route::group(['prefix' => 'workHistory', 'as' => 'workHistory'], function () {
    Route::get('/show', ShowWorkHistoryController::class)->name('.show');

    Route::group(['prefix' => 'create', 'as' => '.create'], function () {
        Route::view('/', 'workHistory.create');
        Route::post('/', CreateWorkHistoryController::class);
    });

    Route::put('/publish', PublishWorkHistoryController::class)->name('.publish');

    Route::group(['prefix' => 'edit', 'as' => '.edit'], function () {
        Route::get('/{workHistory}', EditWorkHistoryController::class);
        Route::patch('/{workHistory}', UpdateWorkHistoryController::class);
    });

    Route::group(['prefix' => 'delete', 'as' => '.delete'], function () {
        Route::delete('/{workHistory}', DeleteWorkHistoryController::class);
    });
});

Route::get('/home', ShowHomeController::class)
    ->middleware(['auth', AccountSetupCompleted::class])
    ->name('home');

Route::get('/profile/{user}', ShowProfileController::class)
    ->middleware(['auth', AccountSetupCompleted::class])
    ->name('profile');

Route::group(['prefix' => 'posts/create', 'as' => 'post.create'], function () {
    Route::view('/', 'posts/create');
    Route::get('/form/{type}', GetPostFormController::class)->name('.form');
    Route::post('/{type}', CreatePostController::class)->name('.execute');
});
