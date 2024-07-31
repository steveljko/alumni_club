<?php

namespace App\Http\Controllers\Auth;

use App\Services\SetNewPassword;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Exceptions\InitialPasswordAlreadyChanged;
use App\Http\Requests\Auth\ChangeInitialPasswordRequest;

#[Group('Auth')]
class ChangeInitialPasswordController extends Controller
{
    /**
     * Change initial password
     *
     * This endpoint is used only for changing user's initial password.
     *
     * @authenticated
     *
     * @var \App\Http\Requests\Auth\ChangeInitialPasswordRequest
     * @var \App\Services\SetNewPassword
     */
    public function __invoke(ChangeInitialPasswordRequest $request, SetNewPassword $service): JsonResponse
    {
        try {
            if ($service(user: Auth::user(), request: $request)) {
                return $this->sendResponse(message: __('auth.initial_password_change.successful'));
            }
        } catch (InitialPasswordAlreadyChanged $ex) {
            return $this->sendFailResponse(message: __('auth.initial_password_change.failed'));
        }
    }
}
