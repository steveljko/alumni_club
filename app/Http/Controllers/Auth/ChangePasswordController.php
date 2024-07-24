<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ChangePasswordRequest;
use Knuckles\Scribe\Attributes\Group;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\SetNewPassword;

#[Group('Auth')]
class ChangePasswordController extends Controller
{
  /**
   * Change password
   *
   * This endpoint is used for changing user passowrd.
   *
   * @authenticated
   *
   * @var \App\Http\Requests\Auth\ChangePasswordRequest $request
   * @var \App\Services\SetNewPassword $service
   * @return \Illuminate\Http\JsonResponse
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
