<?php

namespace App\Http\Controllers\Dashboard\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ShowPostController
{
    public function __invoke(Request $request, Post $post): View|string
    {
        $post->load('user');

        if ($request->header('hx-request')) {
            return view('resources.dashboard.posts.show', compact('post'))->fragment('wrapper');
        }

        return view('resources.dashboard.posts.show', compact('post'));
    }
}
