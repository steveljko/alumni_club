<?php

namespace App\Http\Controllers\Home;

use App\Enums\Post\PostStatus;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ShowHomeController
{
    public function __invoke(Request $request): View|string
    {
        $posts = Post::with(['user', 'comments' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(5);
        }])
            ->withCount(['likes', 'comments'])
            ->where('status', PostStatus::PUBLISHED)
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        if ($request->header('HX-Request')) {
            return view('resources.home.page', compact('posts'))->fragment('posts');
        }

        return view('resources.home.page', compact('posts'));
    }
}
