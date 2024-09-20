<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Resources\User\UserResource;

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

        Log::info('User with ID {id} get their data successfully.', ['id' => Auth::user()->id]);

        return $this->sendOk(
            key: 'auth.successful_user_fetch',
            data: $user
        );
    }
}
