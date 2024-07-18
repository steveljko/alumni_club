<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ChangeInitialPasswordRequest;
use App\Exceptions\InitialPasswordAlreadyChanged;
use Illuminate\Routing\Controllers\HasMiddleware;
use Knuckles\Scribe\Attributes\Group;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\SetNewPassword;

#[Group('Auth')]
class ChangeInitialPasswordController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return ['auth:sanctum'];
  }

  /**
   * Change initial password
   *
   * This endpoint is used only for changing user's initial password.
   *
   * @authenticated
   *
   * @var \App\Http\Requests\Auth\ChangeInitialPasswordRequest $request
   * @var \App\Services\SetNewPassword $service
   * @return \Illuminate\Http\JsonResponse
   */
  public function __invoke(ChangeInitialPasswordRequest $request, SetNewPassword $service): JsonResponse
  {
    try {
      if ($service(user: Auth::user(), request: $request)) {
        return $this->sendResponse(message: __('auth.initial_password_change.successful'));
      }
    } catch (InitialPasswordAlreadyChanged $ex) {
      return $this->sendFailResponse(message: __('auth.initial_password_change.failed'));
    }
  }
}
