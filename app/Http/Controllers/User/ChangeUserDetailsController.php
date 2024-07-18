<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\ChangeUserDetailsRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Knuckles\Scribe\Attributes\Group;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

#[Group('User')]
class ChangeUserDetailsController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return ['auth:sanctum'];
  }

  /**
   * Change user details
   *
   * This endpoint is used for changing user details
   *
   * @authenticated
   *
   * @var \App\Http\Requests\User\ChangeUserDetailsRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function __invoke(ChangeUserDetailsRequest $request): JsonResponse
  {
    $details = Auth::user()
      ->details
      ->update($request->validated());

    return new JsonResponse($details, Response::HTTP_OK);
  }
}
