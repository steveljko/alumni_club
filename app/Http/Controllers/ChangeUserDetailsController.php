<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserDetailsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class ChangeUserDetailsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth'];
    }

    /**
     * @OA\Patch(
     *  path="/change-details",
     *  summary="Change user details endpoint",
     *  description="Endpoint for users to change details in the application.",
     *  tags={"Auth"},
     *
     * @OA\RequestBody(
     *   required=true,
     *
     *   @OA\JsonContent(
     *     required={
     *       "date_of_birth",
     *       "gender",
     *       "email_visible",
     *       "phone_number",
     *       "phone_number_visible",
     *       "uni_start_year",
     *       "uni_finish_year",
     *       "bio"
     *     },
     *
     *     @OA\Property(property="date_of_birth", type="string", format="date", example="1990-01-01"),
     *     @OA\Property(property="gender", type="string", example="male"),
     *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *     @OA\Property(property="email_visible", type="boolean", example=true),
     *     @OA\Property(property="phone_number", type="string", example="+123456789"),
     *     @OA\Property(property="phone_number_visible", type="boolean", example=true),
     *     @OA\Property(property="uni_start_year", type="integer", example=2010),
     *     @OA\Property(property="uni_finish_year", type="integer", example=2014),
     *     @OA\Property(property="bio", type="string", example="This is a short bio."),
     *   ),
     * ),
     *
     *  @OA\Response(
     *    response=200,
     *    description="User details is successfully changed.",
     *
     *    @OA\JsonContent(
     *
     *      @OA\Property(property="success", type="boolean", example=true),
     *      @OA\Property(property="message", type="string"),
     *    )
     *  ),
     *
     *  @OA\Response(
     *   response=401,
     *   description="Unauthorized",
     *
     *   @OA\JsonContent(
     *
     *      @OA\Property(property="message", type="string", example="Unauthorized."),
     *   )
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
    public function __invoke(ChangeUserDetailsRequest $request): JsonResponse
    {
        $details = Auth::user()
            ->details
            ->update($request->validated());

        return new JsonResponse($details, Response::HTTP_OK);
    }
}
