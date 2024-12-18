<?php

namespace App\Http\Actions\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class UserLogin
{
    public function execute(
        array $credentials,
    ): JsonResponse|bool {
        if (! Auth::attempt($credentials)) {
            return new JsonResponse([
                'errors' => ['email' => ['The provided credentials are incorrect.']],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return true;
    }
}
