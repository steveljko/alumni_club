<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\User;
use Knuckles\Scribe\Attributes\Group;

#[Group('Auth')]
class GetAuthenticatedUserData extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return ['auth:sanctum'];
  }

  /**
   * User endpoint
   *
   * This endpoint returns the authenticated user's data.
   *
   * @authenticated
   */
  public function __invoke(): JsonResponse
  {
    $user = User::with('details')->find(Auth::id());

    return new JsonResponse($user, Response::HTTP_OK);
  }
}
