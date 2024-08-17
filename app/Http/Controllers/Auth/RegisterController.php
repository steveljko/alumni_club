<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Knuckles\Scribe\Attributes\Group;
use App\Services\GenerateInitialPassword;
use App\Http\Requests\Auth\RegisterRequest;

#[Group('Admin', 'Auth')]
class RegisterController extends Controller
{
    /**
     * Register
     *
     * This endpoint is used by administrators to register new users into the app.
     *
     * @authenticated
     *
     * @var \App\Http\Requests\RegisterRequest
     * @var \App\Services\GenerateInitialPassword
     */
    public function __invoke(RegisterRequest $request, GenerateInitialPassword $service): JsonResponse
    {
        $data = $request->validated();

        [$password, $hashedPassword] = $service();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashedPassword,
        ]);

        return $this->sendCreated(key: 'auth.successful_register');
    }
}
