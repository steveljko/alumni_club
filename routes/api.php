<?php

use App\Http\Controllers\Auth\ChangeInitialPasswordController;
use App\Http\Controllers\User\ChangeUserDetailsController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\GetAuthenticatedUserData;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Jobs\CreateJobController;
use App\Http\Controllers\Jobs\DeleteJobController;
use App\Http\Controllers\Jobs\UpdateJobController;
use App\Http\Controllers\User\GetUsersController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
  ->name('auth.')
  ->group(function () {
    Route::post('/login', LoginController::class)
      ->name('auth.login');

    Route::post('/register', RegisterController::class)
      ->name('register');

    Route::get('/user', GetAuthenticatedUserData::class)
      ->name('user');

    Route::put('/initial-password', ChangeInitialPasswordController::class)
      ->name('initial_password');

    Route::put('/password', ChangePasswordController::class)
      ->middleware('verify_password_change')
      ->name('password');
  });


Route::prefix('users')
  ->name('users.')
  ->group(function () {
    Route::get('/', GetUsersController::class)
      ->name('get');

    Route::patch('/details', ChangeUserDetailsController::class)
      ->name('change_details');
  });

Route::prefix('jobs')
  ->name('jobs.')
  ->middleware(['auth:sanctum'])
  ->group(function () {
    Route::post('/', CreateJobController::class)
      ->name('create');

    Route::put('/{job}', UpdateJobController::class)
      ->name('update');

    Route::delete('/{job}', DeleteJobController::class)
      ->name('delete');
  });
