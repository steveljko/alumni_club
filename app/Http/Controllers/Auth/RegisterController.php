<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\GenerateInitialPassword;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\User;

#[Group('Admin', 'Auth')]
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
   * Register
   *
   * This endpoint is used for registering new user's into app.
   *
   * @authenticated
   *
   * @var \App\Http\Requests\RegisterRequest $request
   * @var \App\Services\GenerateInitialPassword $service
   * @return \Illuminate\Http\JsonResponse
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

    return $this->sendResponse(
      message: __('auth.successful_register'),
      status: Response::HTTP_CREATED
    );
  }
}
