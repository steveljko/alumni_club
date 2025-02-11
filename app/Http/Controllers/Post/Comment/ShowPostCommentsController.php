<?php

namespace App\Http\Controllers\Post\Comment;

use App\Models\Post;
use Illuminate\View\View;

final class ShowPostCommentsController
{
    public function __invoke(Post $post): View|string
    {
        $post
            ->loadCount(['likes', 'comments'])
            ->load(['comments' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(5);
            }]);

        return view('components.post-card_comments', compact('post'));
    }
}
