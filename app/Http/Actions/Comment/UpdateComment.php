<?php

namespace App\Http\Actions\Comment;

use App\Http\Requests\Comment\AddOrUpdateCommentRequest;
use App\Models\Comment;

final class UpdateComment
{
    public function execute(
        AddOrUpdateCommentRequest $request,
        Comment $comment
    ): bool {
        return $comment->update($request->validated());
    }
}
