<?php

namespace App\Http\Actions\Auth;

use App\Enums\Activity\ActivityEventType;
use App\Http\Actions\Activity\LogUserActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class UserLogin
{
    public function __construct(public LogUserActivity $logUserActivity) {}

    public function execute(
        array $credentials,
    ): JsonResponse|bool {
        if (! Auth::attempt($credentials)) {
            return new JsonResponse([
                'errors' => ['email' => ['The provided credentials are incorrect.']],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->logUserActivity->execute(
            user: auth()->user(),
            model: auth()->user(),
            eventType: ActivityEventType::LOGIN
        );

        return true;
    }
}
