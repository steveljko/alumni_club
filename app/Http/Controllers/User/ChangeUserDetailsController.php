<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\ChangeUserDetailsRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Knuckles\Scribe\Attributes\Group;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

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
    $details = Auth::user()->details;

    $updated = $details->update($request->validated());

    if (!$updated) {
      return $this->sendFailResponse(
        message: __('additional.users.details_failed_update'),
      );
    }

    return $this->sendResponse(
      message: __('additional.users.details_successful_update'),
      data: $details,
    );
  }
}
