<?php

namespace App\Http\Controllers\Post;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ShowUserPostsController
{
    public function __invoke(Request $request, User $user): View|string
    {
        $user->load(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc')->withCount(['likes', 'comments']);
        }]);

        if ($request->header('HX-Request')) {
            if ($request->header('HX-Target') == 'content') {
                return view('resources.post.show', [
                    'user' => $user,
                    'posts' => $user->posts,
                ]);
            }

            if ($request->header('HX-Target') == 'posts') {
                $user->load(['posts' => function ($query) {
                    if ($type = request()->query('type')) {
                        $query->where('type', $type);
                    }
                    $query->orderBy('created_at', 'desc')->withCount(['likes', 'comments']);
                }]);

                return view('resources.post.show', [
                    'user' => $user,
                    'posts' => $user->posts,
                ])->fragment('posts');
            }
        }

        return view('resources.post.show', [
            'user' => $user,
            'posts' => $user->posts,
        ]);
    }
}
