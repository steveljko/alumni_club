<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class GetAuthenticatedUserData extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ["auth:sanctum"];
    }

    public function __invoke(): JsonResponse
    {
        $user = User::with('details')->find(Auth::id());

        return new JsonResponse($user, Response::HTTP_OK);
    }
}
