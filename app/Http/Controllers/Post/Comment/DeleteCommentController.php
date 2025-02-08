<?php

namespace App\Http\Controllers\Post\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Response;

final class DeleteCommentController extends Controller
{
    public function __invoke(Comment $comment): Response
    {
        if (! auth()->user()->can('delete', $comment)) {
            return $this->toast('You are not allowed to delete this comment!');
        }

        $comment->delete();

        $postId = $comment->post_id;

        return $this->trigger("reloadComments.{$postId}");
    }
}
