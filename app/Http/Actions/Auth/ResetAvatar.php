<?php

namespace App\Http\Actions\Auth;

use App\Models\User;

final class ResetAvatar
{
    public function execute(User $user): bool
    {
        return $user->update(['avatar' => 'default.jpg']);
    }
}
