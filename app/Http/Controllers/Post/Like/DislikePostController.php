<?php

namespace App\Http\Controllers\Post\Like;

use App\Http\Actions\Post\DislikePost;
use App\Http\Controllers\Controller;
use App\Models\Post;

final class DislikePostController extends Controller
{
    public function __invoke(Post $post, DislikePost $dislikePost): string
    {
        $ok = $dislikePost->execute(user: auth()->user(), post: $post);

        $post->loadCount('likes');

        return view('components.post-card', compact('post'))->fragment('like');
    }
}
