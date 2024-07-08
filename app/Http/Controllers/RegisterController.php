<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * @param \App\Http\Request\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $initialPassword = Str::password(10, true, true, false, false);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($initialPassword),
        ]);

        return new JsonResponse(
            [
                'success' => true,
                'message' => "Your initial password is $initialPassword",
            ],
            Response::HTTP_CREATED
        );
    }
}
