<?php

namespace App\Exceptions;

use Exception;
use App\Traits\Responses;
use Illuminate\Http\JsonResponse;

class InitialPasswordAlreadyChanged extends Exception
{
    use Responses;

    public function render(): JsonResponse
    {
        return $this->sendForbidden(key: 'auth.initial_password_change.failed');
    }
}
