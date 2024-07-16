<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserDetailsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;

#[Group('Auth')]
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
     */
    public function __invoke(ChangeUserDetailsRequest $request): JsonResponse
    {
        $details = Auth::user()
            ->details
            ->update($request->validated());

        return new JsonResponse($details, Response::HTTP_OK);
    }
}
