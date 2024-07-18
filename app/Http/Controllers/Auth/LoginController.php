<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\LoginRequest;
use Knuckles\Scribe\Attributes\Group;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

#[Group('Auth')]
class LoginController extends Controller
{
  /**
   * Login
   *
   * This endpoint is used for user logging in.
   *
   * @var \App\Http\Requests\LoginRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function __invoke(LoginRequest $request): JsonResponse
  {
    if (Auth::attempt($request->only(['email', 'password']))) {
      $loggedInUser = new UserResource(Auth::user());

      return $this->sendResponse(
        message: __('auth.successful_login'),
        data: $loggedInUser
      );
    } else {
      throw ValidationException::withMessages(['email' => __('auth.failed')]);
    }
  }
}
