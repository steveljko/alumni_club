<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;

#[Group('Auth')]
class GetAuthenticatedUserData extends Controller
{
    /**
     * Get user
     *
     * This endpoint returns the authenticated user's data.
     *
     * @authenticated
     */
    public function __invoke(): JsonResponse
    {
        $user = new UserResource(
            User::with(['details', 'jobs' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])->find(Auth::id())
        );

        return $this->sendResponse(
            message: __('auth.successful_user_fetch'),
            data: $user
        );
    }
}
