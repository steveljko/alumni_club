<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use Illuminate\View\View;

final class ShowPostController
{
    public function __invoke(Post $post): View
    {
        $post->loadCount('comments')->get();

        return view('components.post-card', compact('post'));
    }
}
