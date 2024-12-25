<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class ShowResetPasswordController extends Controller
{
    public function __invoke(string $token): View|RedirectResponse
    {
        if (! User::where('password_reset_token', $token)->exists()) {
            return redirect(route('login'))
                ->with('toast', 'Invalid token is provided!');
        }

        return view('auth.reset_password');
    }
}
