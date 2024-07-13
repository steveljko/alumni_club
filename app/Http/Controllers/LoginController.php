<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
     *    response=403,
     *    description="Invalid email or password",
     *
     *    @OA\JsonContent(
     *
     *      @OA\Property(property="success", type="boolean", example=false),
     *      @OA\Property(property="message", type="string", example="Invalid email or password. Please check your credentials and try again.")
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
     *      @OA\Property(property="errors", type="object")
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
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'Invalid email or password. Please check your credentials and try again.',
                ],
                Response::HTTP_FORBIDDEN
            );
        }
    }
}
