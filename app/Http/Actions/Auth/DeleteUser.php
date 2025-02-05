<?php

namespace App\Http\Actions\Auth;

use App\Enums\Post\PostStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class DeleteUser
{
    public function execute(User $user)
    {
        DB::transaction(function () use ($user) {
            $user->posts()->update(['status' => PostStatus::ARCHIVED]);

            $user->delete();
        });
    }
}
