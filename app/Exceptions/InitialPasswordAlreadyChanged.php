<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class InitialPasswordAlreadyChanged extends Exception
{
    public function render(): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'message' => __('auth.initial_password_change.failed'),
        ], Response::HTTP_FORBIDDEN);
    }
}
