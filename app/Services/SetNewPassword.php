<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;
use App\Exceptions\InitialPasswordAlreadyChanged;
use App\Http\Requests\ChangeInitialPasswordRequest;

class SetNewPassword
{
    /**
     * @param \App\Models\User
     * @param \App\Http\Requests\ChangePasswordRequest|\App\Http\Requests\ChangeInitialPasswordRequest
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
        } elseif ($request instanceof ChangePasswordRequest) {
            $user->password = Hash::make($request->password);

            return $user->save();
        }
    }
}
