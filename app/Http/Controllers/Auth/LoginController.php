<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

#[Group('Auth')]
class LoginController extends Controller
{
    /**
     * Login
     *
     * This endpoint is used for user logging in.
     *
     * @var \App\Http\Requests\LoginRequest
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            $user = new UserResource(Auth::user());

            return $this->sendOk(
                key: 'auth.successful_login',
                data: $user
            );
        }

        throw ValidationException::withMessages(['email' => __('auth.failed')]);
    }
}
