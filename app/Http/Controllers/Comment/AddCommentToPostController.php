<?php

namespace App\Http\Controllers\Comment;

use App\Http\Actions\Comment\AddComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\AddCommentRequest;
use App\Models\Post;
use Illuminate\View\View;

final class AddCommentToPostController extends Controller
{
    public function __invoke(
        AddCommentRequest $request,
        Post $post,
        AddComment $addComment
    ): View {
        $addComment->execute(request: $request, post: $post, user: auth()->user());

        $post
            ->loadCount('comments')
            ->load(['comments' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(5);
            }]);

        return view('components.post-card_comments', compact('post'));
    }
}
