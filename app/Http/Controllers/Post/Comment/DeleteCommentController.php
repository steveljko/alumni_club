<?php

namespace App\Http\Controllers\Post\Comment;

use App\Http\Actions\Comment\DeleteComment;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Response;

final class DeleteCommentController extends Controller
{
    public function __invoke(
        Comment $comment,
        DeleteComment $deleteComment
    ): Response {
        if (! auth()->user()->can('delete', $comment)) {
            return $this->toast('You are not allowed to delete this comment!');
        }

        $ok = $deleteComment->execute($comment);

        $postId = $comment->post_id;

        return $this->trigger("reloadComments.{$postId}");
    }
}
