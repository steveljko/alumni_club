<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use Illuminate\View\View;

final class DeletePostController
{
    public function __invoke(Post $post): View
    {
        return view('resources.post.delete', compact('post'));
    }
}
