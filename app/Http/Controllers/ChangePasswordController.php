<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Services\SetNewPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;

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
        if ($service(Auth::user(), $request)) {
            return new JsonResponse(['success' => true, 'message' => 'Password changed succesfully.']);
        } else {
            return new JsonResponse(['success' => false, 'message' => "Something wan't wrong"]);
        }
    }
}
