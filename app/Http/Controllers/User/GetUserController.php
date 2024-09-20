<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;
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
        return $this->sendResponse(
            message: __('additional.users.get'),
            data: new UserResource($user)
        );
    }
}
