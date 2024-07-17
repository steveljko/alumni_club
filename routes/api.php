<?php

use App\Http\Controllers\ChangeInitialPasswordController;
use App\Http\Controllers\ChangeUserDetailsController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\GetAuthenticatedUserData;
use App\Http\Controllers\Jobs\CreateJobController;
use App\Http\Controllers\Jobs\UpdateJobController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class)->name('login');
Route::get('/user', GetAuthenticatedUserData::class)->name('user');
Route::post('/register', RegisterController::class)->name('register');
Route::put('/change-initial-password', ChangeInitialPasswordController::class)->name('change_initial_password');

Route::middleware(['verify_password_change'])->group(function () {
  Route::put('/change-password', ChangePasswordController::class)
    ->name('change_password');
  Route::patch('/change-details', ChangeUserDetailsController::class)
    ->name('change_details');
});

Route::prefix('jobs')
  ->middleware(['auth:sanctum'])
  ->group(function () {
    Route::post('/', CreateJobController::class)
      ->name('jobs.create');
    Route::put('/{job}', UpdateJobController::class)
      ->name('jobs.update');
  });
