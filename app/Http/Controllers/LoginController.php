<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController
{
  /**
   * @OA\Post(
   *  path="/login",
   *  summary="User login",
   *  description="Authenticate user",
   *  tags={"Auth"},
   *
   *  @OA\RequestBody(
   *    required=true,
   *
   *    @OA\JsonContent(
   *      required={"email","password"},
   *
   *      @OA\Property(property="email", type="string", format="email", example="user@example.com"),
   *      @OA\Property(property="password", type="string", format="password", example="password123")
   *    ),
   *  ),
   *
   *  @OA\Response(
   *    response=200,
   *    description="User is successfully logged in.",
   *
   *    @OA\JsonContent(
   *
   *      @OA\Property(property="success", type="boolean", example=true),
   *    )
   *  ),
   *
   *  @OA\Response(
   *   response=422,
   *   description="Laravel validation",
   *
   *   @OA\JsonContent(
   *
   *      @OA\Property(property="message", type="string"),
   *    @OA\Property(property="errors", type="object")
   *   )
   *  ),
   * ),
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
