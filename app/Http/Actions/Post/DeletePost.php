<?php

namespace App\Http\Actions\Post;

use App\Models\Post;

final class DeletePost
{
    public function execute(Post $post): bool
    {
        return $post->delete();
    }
}
