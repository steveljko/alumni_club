<?php

namespace App\Services;

use App\Models\User;
use App\Http\Requests\ChangePasswordRequest;
use App\Exceptions\InitialPasswordAlreadyChanged;

class SetNewPassword
{
    // TODO: Check if request is ChangePasswordRequest or ChangeInitialPasswordRequest

    /**
     * @param \App\Models\User
     * @param \App\Http\Requests\ChangePasswordRequest
     * @return bool
     */
    public function __invoke(User $user, ChangePasswordRequest $request): boolean
    {
        if ($user->initial_password_changed == false) {
            $user->password = $request->password;
            $user->save();
            return true;
        }

        throw new InitialPasswordAlreadyChanged();
    }
}
