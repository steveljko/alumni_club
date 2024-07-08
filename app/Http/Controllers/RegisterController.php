<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RegisterRequest;
use App\Services\GenerateInitialPassword;

class RegisterController extends Controller
{
    /**
     * @param \App\Http\Request\RegisterRequest $request
     * @param \App\Services\GenerateInitialPassword $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request, GenerateInitialPassword $service): JsonResponse
    {
        // TODO: Allow admin to print pdf with login credentials

        $data = $request->validated();

        [$password, $hashedPassword] = $service();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashedPassword,
        ]);

        return new JsonResponse(
            [
                'success' => true,
                'message' => "Your initial password is $password",
            ],
            Response::HTTP_CREATED
        );
    }
}
