<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Services\SetNewPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth'];
    }

    /**
     * @OA\Put(
     *  path="/change-password",
     *  summary="Change user password",
     *  description="Change password...",
     *  tags={"Auth"},
     *
     *  @OA\RequestBody(
     *    required=true,
     *
     *    @OA\JsonContent(
     *      required={"password", "password_confirmation"},
     *
     *      @OA\Property(property="password", type="string", format="password", example="password123"),
     *      @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *    ),
     *  ),
     *
     *  @OA\Response(
     *    response=200,
     *    description="User password is changed succesfully.",
     *
     *    @OA\JsonContent(
     *
     *      @OA\Property(property="success", type="boolean", example=true),
     *    )
     *  ),
     *
     *  @OA\Response(
     *   response=422,
     *   description="Laravel validation",
     *
     *   @OA\JsonContent(
     *
     *      @OA\Property(property="message", type="string"),
     *      @OA\Property(property="errors", type="object")
     *   )
     *  ),
     * ),
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
