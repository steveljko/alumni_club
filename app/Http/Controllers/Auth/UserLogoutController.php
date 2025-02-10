<?php

namespace App\Http\Controllers\Auth;

use App\Http\Actions\Auth\UserLogout;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

final class UserLogoutController extends Controller
{
    public function __invoke(UserLogout $userLogout): Response
    {
        $userLogout->execute();

        return $this->redirectWithToast(
            route: 'auth.login',
            message: __('auth.logout'),
        );
    }
}
