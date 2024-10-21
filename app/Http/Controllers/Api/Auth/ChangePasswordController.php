<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\SetNewPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
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
            Log::info('User {name} with ID {id} successfully changed their password.', ['name' => Auth::user()->name, 'id' => Auth::user()->id]);

            return $this->sendOk(key: 'auth.password_change.successful');
        }

        Log::warning('User {name} with ID {id} attempted to change their password, but failed.', ['name' => Auth::user()->name, 'id' => Auth::user()->id]);

        return $this->sendForbidden(key: 'auth.password_change.failed');
    }
}
