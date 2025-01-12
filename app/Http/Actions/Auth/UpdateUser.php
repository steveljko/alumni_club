<?php

namespace App\Http\Actions\Auth;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

final class UpdateUser
{
    public function execute(UpdateUserRequest $request, User $user): bool
    {
        return $user->update($request->validated());
    }
}
