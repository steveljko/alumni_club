<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Activity\ActivityEventType;
use App\Models\Activity;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final class ShowDashboardController
{
    public function __invoke(Request $request)
    {
        $stats = Cache::rememberForever('dashboard_stats', function () {
            return [
                'users_count' => User::count(),
                'posts_count' => Post::count(),
                'comments_count' => Comment::count(),
            ];
        });

        $activities = Activity::when($event = $request->query('event'), function ($query, $event) {
            return $query->where('event', $event);
        })->orderBy('created_at', 'DESC')->limit(10)->get();
        $activitiesEvent = ActivityEventType::cases();

        if ($request->header('HX-Request')) {
            return view('resources.dashboard.dashboard', compact('stats', 'activities', 'activitiesEvent'))
                ->fragment('table');
        }

        return view('resources.dashboard.dashboard', compact('stats', 'activities', 'activitiesEvent'));
    }
}
