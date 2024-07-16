<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Knuckles\Scribe\Attributes\Group;

#[Group('Auth')]
class LoginController
{
  /**
   * Login
   *
   * This endpoint is used for user logging in.
   */
  public function __invoke(LoginRequest $request): JsonResponse
  {
    if (Auth::attempt($request->only(['email', 'password']))) {
      return new JsonResponse([
        'success' => true,
        'user' => Auth::user(),
      ], Response::HTTP_OK);
    } else {
      throw ValidationException::withMessages(['email' => 'Provided credentials do not match our records.']);
    }
  }
}
