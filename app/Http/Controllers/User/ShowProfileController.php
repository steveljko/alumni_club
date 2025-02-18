<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class ShowProfileController
{
    public function __invoke(User $user): View
    {
        $user->load(['posts' => function ($query) {
            $query
                ->orderBy('created_at', 'desc')
                ->withCount(['likes', 'comments']);
        }, 'posts.user', 'currentWork']);

        $stats = Cache::rememberForever("user_stats:{$user->id}", function () use ($user) {
            return [
                'posts_count' => $user->posts()->count(),
                'comments_count' => $user->comments()->count(),
                'likes_count' => $user->likedPosts()->count(),
            ];
        });

        if (request()->hasHeader('HX-Request')) {
            $user->load(['posts' => function ($query) {
                if ($type = request()->query('type')) {
                    $query->where('type', $type);
                }
                $query->orderBy('created_at', 'desc');
            }]);

            return view('resources.user.profile.show', compact('user', 'stats'));
        }

        return view('resources.user.profile.show', compact('user', 'stats'));
    }
}
