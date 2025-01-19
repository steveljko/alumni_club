<?php

namespace App\Http\Controllers\Comment;

use App\Models\Comment;

final class EditCommentController
{
    public function __invoke(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }
}
