<?php

namespace App\Http\Actions\Auth;

use App\Http\Requests\ChangePasswordWithVerificationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class ChangePassword
{
    public function execute(
        ChangePasswordWithVerificationRequest $request,
        User $user
    ): bool {
        if (! Hash::check($request->current_password, $user->password)) {
            return false;
        }

        return $user->update(['password' => Hash::make($request->password)]);
    }
}
