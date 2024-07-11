<?php

use App\Http\Controllers\ChangeUserDetailsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ChangeInitialPasswordController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', LoginController::class)->name('login');
Route::post('/register', RegisterController::class)->name('register');
Route::put('/change-initial-password', ChangeInitialPasswordController::class)->name('change_initial_password');
Route::put('/change-password', ChangePasswordController::class)->name('change_password');
Route::patch('/change-details', ChangeUserDetailsController::class)->name('change_details');
