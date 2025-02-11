<?php

namespace App\Http\Actions\Comment;

use App\Models\Comment;

final class DeleteComment
{
    public function execute(Comment $comment): void
    {
        $comment->delete();

        $postId = $comment->post_id;
    }
}
