<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    /**
     * @param \App\Http\Requests\LoginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            return new JsonResponse([
                "success" => true,
                "user" => $request->user()
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse(["success" => false], Response::HTTP_FORBIDDEN);
        }
    }
}
