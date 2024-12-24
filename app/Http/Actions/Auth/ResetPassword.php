<?php

namespace App\Http\Actions\Auth;

use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class ResetPassword
{
    public function execute(ResetPasswordRequest $request): bool
    {
        $user = User::where('password_reset_token', $request->token)->firstOrFail();

        $ok = $user->setNewPassword(password: $request->password);

        Auth::loginUsingId($user->id);

        return $ok;
    }
}
