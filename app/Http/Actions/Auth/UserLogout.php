<?php

namespace App\Http\Actions\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

final class UserLogout extends Controller
{
    public function __invoke(): Response
    {
        auth()->logout();

        return $this->redirectWithToast(
            route: 'auth.login',
            message: __('auth.logout'),
        );
    }
}
