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
        return ['auth'];
    }

    /**
     * @OA\Put(
     *  path="/change-initial-password",
     *  summary="Change initial user password",
     *  description="Change password on first login after using initially generated password",
     *  tags={"Auth"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *      required={"password", "password_confirmation"},
     *      @OA\Property(property="password", type="string", format="password", example="password123"),
     *      @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *    ),
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="User password is changed succesfully.",
     *    @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example=true),
     *      @OA\Property(property="message", type="string"),
     *    )
     *  ),
     *  @OA\Response(
     *   response=422,
     *   description="Laravel validation",
     *   @OA\JsonContent(
     *      @OA\Property(property="message", type="string"),
     *      @OA\Property(property="errors", type="object"),
     *   )
     *  ),
     * ),
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
