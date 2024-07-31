<?php

namespace App\Http\Controllers\Auth;

use App\Services\SetNewPassword;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Auth\ChangePasswordRequest;

#[Group('Auth')]
class ChangePasswordController extends Controller
{
    /**
     * Change password
     *
     * This endpoint is used for changing user passowrd.
     *
     * @authenticated
     *
     * @var \App\Http\Requests\Auth\ChangePasswordRequest
     * @var \App\Services\SetNewPassword
     */
    public function __invoke(ChangePasswordRequest $request, SetNewPassword $service): JsonResponse
    {
        if ($service(user: Auth::user(), request: $request)) {
            return $this->sendResponse(message: __('auth.password_change.successful'));
        }

        return $this->sendFailResponse(message: __('auth.password_change.failed'));

    }
}
