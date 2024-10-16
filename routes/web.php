<?php

use App\Http\Controllers\Web\Dashboard\DashboardUsersController;

// TODO: implement middleware only for admins to access
Route::prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', function () {
            return view('dashboard/overview');
        })->name('index');

        Route::get('users', DashboardUsersController::class)
            ->name('users');
    });
