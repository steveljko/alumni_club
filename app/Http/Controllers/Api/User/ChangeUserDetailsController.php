<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Resources\User\UserDetailsResource;

#[Group('User')]
class ChangeUserDetailsController extends Controller
{
    /**
     * Change user details
     *
     * This endpoint is used for changing user details
     *
     * @authenticated
     *
     * @var \App\Http\Requests\User\ChangeUserDetailsRequest
     */
    public function __invoke(ChangeUserDetailsRequest $request): JsonResponse
    {
        $details = Auth::user()->details;

        $updated = $details->update(
            $request->validated() + ['changed' => true]
        );

        Log::info('User with ID {userId} successfully changed their details.', ['userId' => Auth::user()->id]);

        if (! $updated) {
            return $this->sendFailResponse(
                message: __('additional.users.details_failed_update'),
            );
        }

        return $this->sendResponse(
            message: __('additional.users.details_successful_update'),
            data: new UserDetailsResource($details),
        );
    }
}
