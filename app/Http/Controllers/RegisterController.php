<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use App\Services\GenerateInitialPassword;
use App\Http\Requests\RegisterRequest;
use Knuckles\Scribe\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\User;

#[Group('Auth')]
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

    $user->details()->create([
      'date_of_birth' => null,
      'gender' => null,
      'phone_number' => null,
      'uni_start_year' => null,
      'uni_finish_year' => null,
      'bio' => null,
    ]);

    return $this->sendResponse("User is successfully registered.", null, Response::HTTP_CREATED);
  }
}
