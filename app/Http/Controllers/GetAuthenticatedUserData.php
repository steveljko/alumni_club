<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\User;

#[Group('Auth')]
class GetAuthenticatedUserData extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return ['auth:sanctum'];
  }

  /**
   * Get user
   *
   * This endpoint returns the authenticated user's data.
   *
   * @authenticated
   *
   * @return \App\Http\JsonResponse
   */
  public function __invoke(): JsonResponse
  {
    $user = new UserResource(
      User::with(['details', 'jobs' => function ($query) {
        $query->orderBy('created_at', 'desc');
      }])->find(Auth::id())
    );

    return $this->sendResponse('User fetched succesfully', $user);
  }
}
