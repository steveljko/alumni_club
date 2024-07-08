<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RegisterRequest;
use App\Services\GenerateInitialPassword;
use Illuminate\Routing\Controllers\HasMiddleware;

class RegisterController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            'permission:create user',
        ];
    }

    /**
     * @OA\Post(
     *  path="/register",
     *  summary="User register",
     *  description="Endpoint for administrators to register a new user in the application.",
     *  tags={"Auth"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *      required={"name","email"},
     *      @OA\Property(property="name", type="string", example="User example"),
     *      @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *    ),
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="User is successfully registered.",
     *    @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example=true),
     *      @OA\Property(property="message", type="string"),
     *    )
     *  ),
     *  @OA\Response(
     *   response=422,
     *   description="Laravel validation",
     *   @OA\JsonContent(
     *      @OA\Property(property="message", type="string"),
     *      @OA\Property(property="errors", type="object")
     *   )
     *  ),
     * ),
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
