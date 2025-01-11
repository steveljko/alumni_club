<?php

namespace App\Http\Controllers\Home;

use App\Models\Post;
use Illuminate\View\View;

final class ShowHomeController
{
    public function __invoke(): View
    {
        $posts = Post::with('default', 'event', 'job', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        return view('home.main', compact('posts'));
    }
}
