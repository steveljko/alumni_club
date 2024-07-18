<?php

use App\Http\Controllers\Auth\ChangeInitialPasswordController;
use App\Http\Controllers\User\ChangeUserDetailsController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\GetAuthenticatedUserData;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Jobs\CreateJobController;
use App\Http\Controllers\Jobs\DeleteJobController;
use App\Http\Controllers\Jobs\UpdateJobController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class)->name('auth.login');
Route::get('/user', GetAuthenticatedUserData::class)->name('auth.user');
Route::post('/register', RegisterController::class)->name('auth.register');
Route::put('/change-initial-password', ChangeInitialPasswordController::class)->name('auth.change_initial_password');

Route::middleware(['verify_password_change'])->group(function () {
  Route::put('/change-password', ChangePasswordController::class)
    ->name('auth.change_password');
  Route::patch('/change-details', ChangeUserDetailsController::class)
    ->name('user.change_details');
});

Route::prefix('jobs')
  ->middleware(['auth:sanctum'])
  ->group(function () {
    Route::post('/', CreateJobController::class)
      ->name('jobs.create');
    Route::put('/{job}', UpdateJobController::class)
      ->name('jobs.update');
    Route::delete('/{job}', DeleteJobController::class)
      ->name('jobs.delete');
  });
