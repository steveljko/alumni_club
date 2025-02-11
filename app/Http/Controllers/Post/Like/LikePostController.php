<?php

namespace App\Http\Controllers\Post\Like;

use App\Http\Actions\Post\LikePost;
use App\Http\Controllers\Controller;
use App\Models\Post;

final class LikePostController extends Controller
{
    public function __invoke(Post $post, LikePost $likePost): string
    {
        $ok = $likePost->execute(user: auth()->user(), post: $post);

        $post->loadCount('likes');

        return view('components.post-card', compact('post'))->fragment('like');
    }
}
