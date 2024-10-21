<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\UrlParam;
use App\Http\Resources\User\UserResource;

#[Group('User')]
#[UrlParam('user_id', 'User\'s ID', required: true, example: '1')]
class GetUserController extends Controller
{
    /**
     * Get user by id
     */
    public function __invoke(User $user): JsonResponse
    {
        Log::info('User with ID {userId} successfully fetched.', ['userId' => $user->id]);

        return $this->sendResponse(
            message: __('additional.users.get'),
            data: new UserResource($user)
        );
    }
}
