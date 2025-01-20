<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Response;

final class DeleteCommentController extends Controller
{
    public function __invoke(Comment $comment): Response
    {
        $comment->delete();

        $postId = $comment->post_id;

        return $this->trigger("reloadComments.{$postId}");
    }
}
