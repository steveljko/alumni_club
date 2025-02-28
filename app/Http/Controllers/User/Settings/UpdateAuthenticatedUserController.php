<?php

namespace App\Http\Controllers\User\Settings;

use App\Http\Actions\Auth\UpdateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Response;

final class UpdateAuthenticatedUserController extends Controller
{
    public function __invoke(
        UpdateUserRequest $request,
        UpdateUser $updateUser
    ): Response {
        $ok = $updateUser->execute(request: $request, user: auth()->user());

        if (! $ok) {
            return $this->toast(__('auth.try_again'));
        }

        return $this->redirectWithToast(
            route: 'users.settings',
            message: __('auth.successful_user_update')
        );
    }
}
