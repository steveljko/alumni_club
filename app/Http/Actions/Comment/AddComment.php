<?php

namespace App\Http\Actions\Comment;

use App\Http\Requests\Comment\AddOrUpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

final class AddComment
{
    public function execute(
        AddOrUpdateCommentRequest $request,
        Post $post,
        User $user,
    ): Comment {
        return $post->comments()->create(array_merge(
            $request->validated() + ['user_id' => $user->id],
        ));
    }
}
