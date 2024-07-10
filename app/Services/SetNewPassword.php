<?php

namespace App\Services;

use App\Http\Requests\ChangeInitialPasswordRequest;
use App\Models\User;
use App\Http\Requests\ChangePasswordRequest;
use App\Exceptions\InitialPasswordAlreadyChanged;
use Illuminate\Support\Facades\Hash;

class SetNewPassword
{
    /**
     * @param \App\Models\User
     * @param \App\Http\Requests\ChangePasswordRequest|\App\Http\Requests\ChangeInitialPasswordRequest
     * @return bool
     */
    public function __invoke(User $user, ChangePasswordRequest|ChangeInitialPasswordRequest $request): bool
    {
        if ($request instanceof ChangeInitialPasswordRequest) {
            if ($user->initial_password_changed == false) {
                $user->password = Hash::make($request->password);
                $user->initial_password_changed = true;
                return $user->save();
            }

            throw new InitialPasswordAlreadyChanged();
        } else if ($request instanceof ChangePasswordRequest) {
            $user->password = Hash::make($request->password);
            return $user->save();
        }
    }
}
