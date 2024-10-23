<?php

namespace App\Http\Controllers\Web\Auth;

use App\Enums\UserRole;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController
{
    public function __invoke(): View
    {
        return view('auth/login');
    }

    public function handle(Request $request): ?RedirectResponse
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            if (Auth::user()->role == UserRole::ADMIN->value) {
                return redirect('/dashboard');
            }
        }
    }
}
