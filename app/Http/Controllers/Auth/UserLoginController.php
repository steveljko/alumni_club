<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\HtmxResponse;
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

        return (new HtmxResponse)
            ->redirectTo(self::REDIRECT_TO)
            ->toast('Successfully logged in!')
            ->send();
    }
}
