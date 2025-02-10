<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Actions\Auth\UpdateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Response;

final class UpdateUserController extends Controller
{
    public function __invoke(
        UpdateUserRequest $request,
        UpdateUser $updateUser,
        User $user
    ): Response {
        if (! auth()->user()->can('update', $user)) {
            return $this->toast('You do not have permission to update this resource.');
        }

        $ok = $updateUser->execute(request: $request, user: $user);

        if (! $ok) {
            $this->toast(__('auth.try_again'));
        }

        return $this->triggerWithToast(
            event: 'loadUsers',
            message: __('auth.successful_user_update')
        );
    }
}
