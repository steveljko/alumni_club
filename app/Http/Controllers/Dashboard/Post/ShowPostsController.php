<?php

namespace App\Http\Controllers\Dashboard\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ShowPostsController
{
    public function __invoke(Request $request): View|string
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(10);

        if ($request->header('hx-request')) {
            return view('resources.dashboard.posts.page', compact('posts'))->fragment('wrapper');
        }

        return view('resources.dashboard.posts.page', compact('posts'));
    }
}
