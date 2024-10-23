<?php

namespace App\Http\Controllers\Web\Auth;

use App\Enums\UserRole;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class LoginController
{
    public function __invoke(): View
    {
        return view('auth/login');
    }

    public function handle(LoginRequest $request): ?RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            if (Auth::user()->role == UserRole::ADMIN->value) {
                return redirect()->route('web.dashboard.index');
            }
        }

        throw ValidationException::withMessages(['email' => __('auth.failed')]);
    }
}
