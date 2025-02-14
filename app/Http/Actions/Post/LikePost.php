<?php

namespace App\Http\Actions\Post;

use App\Models\Post;
use App\Models\User;

final class LikePost
{
    public function execute(User $user, Post $post): bool
    {
        if ($user->isLiked($post)) {
            return false;
        }

        $user->likedPosts($post)->attach($post);

        return true;
    }
}
