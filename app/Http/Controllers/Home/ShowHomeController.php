<?php

namespace App\Http\Controllers\Home;

use App\Enums\Post\PostStatus;
use App\Models\Post;
use Illuminate\View\View;

final class ShowHomeController
{
    public function __invoke(): View
    {
        $posts = Post::with(['user', 'comments' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(5);
        }])
            ->withCount('comments')
            ->where('status', PostStatus::PUBLISHED)
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        return view('resources.home.page', compact('posts'));
    }
}
