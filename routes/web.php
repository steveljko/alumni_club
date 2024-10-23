<?php

use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\LogoutController;
use App\Http\Controllers\Web\Dashboard\DashboardUsersController;

Route::name('web.')->group(function () {
    Route::name('auth.')
        ->group(function () {
            Route::get('/login', LoginController::class)->name('login');
            Route::post('/login', [LoginController::class, 'handle'])->name('login.handle');

            Route::get('/logout', LogoutController::class)
                ->name('logout')
                ->middleware('auth:sanctum');
        });

    Route::prefix('dashboard')
        ->name('dashboard.')
        ->middleware(['auth:sanctum', 'role:admin'])
        ->group(function () {
            Route::get('/', function () {
                return view('dashboard/overview');
            })->name('index');

            Route::get('users', DashboardUsersController::class)
                ->name('users');
        });
});
