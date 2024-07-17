<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\ChangePasswordRequest;
use Knuckles\Scribe\Attributes\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Services\SetNewPassword;

#[Group('Auth')]
class ChangePasswordController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return ['auth:sanctum'];
  }

  /**
   * Change password
   *
   * This endpoint is used for changing user passowrd.
   *
   * @authenticated
   */
  public function __invoke(ChangePasswordRequest $request, SetNewPassword $service): JsonResponse
  {
    if ($service(user: Auth::user(), request: $request)) {
      return $this->sendResponse(message: __('auth.password_change.successful'));
    } else {
      return $this->sendFailResponse(message: __('auth.password_change.failed'));
    }
  }
}
