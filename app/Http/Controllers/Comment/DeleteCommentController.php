<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Response;

final class DeleteCommentController extends Controller
{
    public function __invoke(Comment $comment): Response
    {
        if (! auth()->user()->can('delete', $comment)) {
            return $this->redirectWithToast('home', 'You are not alloed to update this!');
        }

        $comment->delete();

        $postId = $comment->post_id;

        return $this->trigger("reloadComments.{$postId}");
    }
}
