<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
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
        if (Auth::guard('web')->attempt($request->only(['email', 'password']))) {
            $user = new UserResource(Auth::user());

            Log::info('User with ID {id} was successfully logged in.', ['id' => Auth::user()->id]);

            return $this->sendOk(
                key: 'auth.successful_login',
                data: $user
            );
        }

        Log::warning('User with email {email} failed to log in.', ['email' => $request->input('email')]);
        throw ValidationException::withMessages(['email' => __('auth.failed')]);
    }
}
