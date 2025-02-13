<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

final class ShowDashboardController
{
    public function __invoke()
    {
        $stats = Cache::rememberForever('dashboard_stats', function () {
            return [
                'users_count' => User::count(),
                'posts_count' => Post::count(),
                'comments_count' => Comment::count(),
            ];
        });

        $activities = Activity::orderBy('created_at', 'DESC')->limit(10)->get();

        return view('resources.dashboard.dashboard', compact('stats', 'activities'));
    }
}
