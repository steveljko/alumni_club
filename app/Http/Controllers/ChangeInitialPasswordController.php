<?php

namespace App\Http\Controllers;

use App\Exceptions\InitialPasswordAlreadyChanged;
use App\Http\Requests\ChangeInitialPasswordRequest;
use App\Services\SetNewPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

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
   */
  public function __invoke(ChangeInitialPasswordRequest $request, SetNewPassword $service): JsonResponse
  {
    try {
      if ($service(Auth::user(), $request)) {
        return new JsonResponse(['success' => true, 'message' => 'Password changed succesfully.']);
      }
    } catch (InitialPasswordAlreadyChanged $ex) {
      return new JsonResponse(['success' => false, 'message' => 'Initial password for this account is already changed!']);
    }
  }
}
