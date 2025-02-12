<?php

namespace App\Http\Controllers\Home;

use App\Enums\Post\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

final class ShowHomeController extends Controller
{
    public function __invoke(Request $request): Response|View|string
    {
        $posts = Post::with(['user', 'comments' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(5);
        }])
            ->withCount(['likes', 'comments'])
            ->where('status', PostStatus::PUBLISHED)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        if ($request->header('HX-Request')) {
            return view('resources.home.page', compact('posts'))->fragment('posts');
        }

        return view('resources.home.page', compact('posts'));
    }
}
