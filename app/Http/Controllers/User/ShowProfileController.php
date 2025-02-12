<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

final class ShowProfileController
{
    public function __invoke(User $user): View|string
    {
        $user->load(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc')->withCount(['likes', 'comments']);
        }, 'posts.user']);

        [$postCount, $commentCount] = Redis::hmget('user_stats:'.$user->id, ['posts', 'comments']);

        if (request()->hasHeader('HX-Request')) {
            $user->load(['posts' => function ($query) {
                if ($type = request()->query('type')) {
                    $query->where('type', $type);
                }
                $query->orderBy('created_at', 'desc');
            }]);

            return view('resources.user.profile.show', compact('user', 'postCount', 'commentCount'))
                ->fragments(['posts', 'posts-count']);
        }

        return view('resources.user.profile.show', compact('user', 'postCount', 'commentCount'));
    }
}
