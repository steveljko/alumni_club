<?php

namespace App\Http\Controllers\Comment;

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
        $ok = $updateComment->execute(request: $request, comment: $comment);

        $postId = $comment->post_id;

        return $this->trigger("reloadComments.${postId}");
    }
}
