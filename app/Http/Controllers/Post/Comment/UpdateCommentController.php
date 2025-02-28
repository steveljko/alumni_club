<?php

namespace App\Http\Controllers\Post\Comment;

use App\Http\Actions\Comment\UpdateComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\AddOrUpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Response;

final class UpdateCommentController extends Controller
{
    public function __invoke(
        AddOrUpdateCommentRequest $request,
        Comment $comment,
        UpdateComment $updateComment,
    ): Response {
        if (! auth()->user()->can('update', $comment)) {
            return $this->toast('You are not allowed to edit this comment!');
        }

        $ok = $updateComment->execute(request: $request, comment: $comment);

        $postId = $comment->post_id;

        return $this->trigger("reloadComments.${postId}");
    }
}
