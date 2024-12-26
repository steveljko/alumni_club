<?php

namespace App\Http\Actions\Auth;

use App\Http\Requests\ChangePasswordRequest;

final class ChangeInitialPassword
{
    public function execute(ChangePasswordRequest $request): bool
    {
        $user = auth()->user();

        return $user->changeInitialPassword(password: $request->password);
    }
}
