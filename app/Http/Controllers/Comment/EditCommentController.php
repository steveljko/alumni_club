<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;

final class EditCommentController extends Controller
{
    public function __invoke(Comment $comment)
    {
        if (! auth()->user()->can('edit', $comment)) {
            return $this->redirectWithToast('home', 'You are not alloed to edit this!');
        }

        return view('comments.edit', compact('comment'));
    }
}
