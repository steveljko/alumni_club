<?php

use App\Http\Controllers\ChangeInitialPasswordController;
use App\Http\Controllers\ChangeUserDetailsController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\GetAuthenticatedUserData;
use App\Http\Controllers\CreateJobController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/healthcheck', function () {
  return [
    'status' => 'up',
    'services' => [
      'database' => 'up',
      'redis' => 'up',
    ],
  ];
});

Route::get('/user', GetAuthenticatedUserData::class)->name('user');
Route::post('/login', LoginController::class)->name('login');
Route::post('/register', RegisterController::class)->name('register');
Route::put('/change-initial-password', ChangeInitialPasswordController::class)->name('change_initial_password');

Route::middleware(['verify_password_change'])->group(function () {
    Route::put('/change-password', ChangePasswordController::class)->name('change_password');
    Route::patch('/change-details', ChangeUserDetailsController::class)->name('change_details');
    Route::post('/job/create', CreateJobController::class)->name('job.create');
});
