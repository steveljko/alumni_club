<?php

namespace App\Http\Actions\Auth;

use App\Http\Requests\ForgotPasswordRequest;
use App\Models\User;

final class ForgotPassword
{
    /**
     * Send password recovery mail to user
     */
    public function execute(
        ForgotPasswordRequest $request
    ): void {
        $user = User::where('email', $request->email)->first();

        $user->getPasswordRecoveryMail();
    }
}
