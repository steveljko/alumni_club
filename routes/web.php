<?php

use App\Models\User;
use Illuminate\Http\Request;

Route::get('/dashboard', function () {
    return view('dashboard/overview');
})->name('dashboard.index');

Route::get('/dashboard/users', function (Request $request) {
    $users = User::with('details');

    if ($request->query('name')) {
        $users->where('name', 'LIKE', '%'.$request->name.'%');
    }

    $users = $users->paginate(10)->appends(request()->query());

    return view('dashboard/users', compact('users'));
})->name('dashboard.users');
