<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\User\GetUserController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\User\GetUsersController;
use App\Http\Controllers\Api\Jobs\CreateJobController;
use App\Http\Controllers\Api\Jobs\DeleteJobController;
use App\Http\Controllers\Api\Jobs\UpdateJobController;
use App\Http\Controllers\Api\Posts\DeletePostController;
use App\Http\Controllers\Api\Posts\UpdatePostController;
use App\Http\Controllers\Api\Auth\ChangePasswordController;
use App\Http\Controllers\Api\Auth\GetAuthenticatedUserData;
use App\Http\Controllers\Api\Posts\CreateJobPostController;
use App\Http\Controllers\Api\Posts\CreateEventPostController;
use App\Http\Controllers\Api\User\ChangeUserDetailsController;
use App\Http\Controllers\Api\Posts\CreateDefaultPostController;
use App\Http\Controllers\Api\Auth\ChangeInitialPasswordController;

Route::prefix('auth')
    ->name('auth.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/login', LoginController::class)
            ->withoutMiddleware('auth:sanctum')
            ->name('login');

        Route::get('/user', GetAuthenticatedUserData::class)
            ->name('user');

        Route::put('/initial-password', ChangeInitialPasswordController::class)
            ->name('change_initial_password');

        Route::put('/password', ChangePasswordController::class)
            ->middleware('verify_password_change')
            ->name('change_password');

        Route::post('/register', RegisterController::class)
            ->middleware(['role:admin'])
            ->name('register');
    });

Route::prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get('/', GetUsersController::class)
            ->name('all');

        Route::get('/{user}', GetUserController::class)
            ->name('get');

        Route::patch('/details', ChangeUserDetailsController::class)
            ->middleware(['auth:sanctum'])
            ->name('change_details');
    });

Route::prefix('jobs')
    ->name('jobs.')
    ->middleware(['auth:sanctum', 'role:default'])
    ->group(function () {
        Route::post('/', CreateJobController::class)
            ->name('create');

        Route::put('/{job}', UpdateJobController::class)
            ->name('update');

        Route::delete('/{job}', DeleteJobController::class)
            ->name('delete');
    });

Route::prefix('posts')
    ->name('posts.')
    ->middleware(['auth:sanctum', 'role:default'])
    ->group(function () {
        Route::post('/', CreateDefaultPostController::class)
            ->name('create.default');

        Route::post('/event', CreateEventPostController::class)
            ->name('create.event');

        Route::post('/job', CreateJobPostController::class)
            ->name('create.job');

        Route::put('/{post}', UpdatePostController::class)
            ->name('update');

        Route::delete('/{post}', DeletePostController::class)
            ->name('delete');
    });
