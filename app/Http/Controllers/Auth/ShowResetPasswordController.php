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
            return $this->redirectWithToast(
                route: 'auth.login',
                message: __('auth.invalid_password_reset_token'),
            );
        }

        return view('resources.auth.reset_password');
    }
}
