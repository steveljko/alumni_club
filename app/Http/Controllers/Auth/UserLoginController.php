<?php

namespace App\Http\Controllers\Auth;

use App\Http\Actions\Auth\UserLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class UserLoginController extends Controller
{
    public const REDIRECT_TO = 'home';

    public function __invoke(
        UserLoginRequest $request,
        UserLogin $userLogin,
    ): Response|JsonResponse {
        $result = $userLogin->execute(
            credentials: $request->only(['email', 'password'])
        );

        if ($result instanceof JsonResponse) {
            return $result;
        }

        return $this->redirectWithToast(
            route: self::REDIRECT_TO,
            message: __('successful_login'),
        );
    }
}
