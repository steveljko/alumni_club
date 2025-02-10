<?php

namespace App\Http\Actions\Auth;

final class UserLogout
{
    public function execute(): void
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
