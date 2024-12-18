<?php

use App\Http\Controllers\Auth\UserLoginController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'login', 'as' => 'login'], function () {
    Route::view('/', 'auth.login');
    Route::post('/', UserLoginController::class)->name('.execute');
});

Route::view('/home', 'home.main')->middleware('auth')->name('home');
