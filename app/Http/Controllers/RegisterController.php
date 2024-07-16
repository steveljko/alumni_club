<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\GenerateInitialPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Knuckles\Scribe\Attributes\Group;

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

    return new JsonResponse(
      [
        'success' => true,
        'message' => "Your initial password is $password",
      ],
      Response::HTTP_CREATED
    );
  }
}
