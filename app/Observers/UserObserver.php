<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Redis::hmset("user_stats:$user->id", [
            'posts' => 0,
            'comments' => 0,
            'likes' => 0,
        ]);

        Cache::forget('dashboard_stats');

        $user->assignRole('alumni');
    }
}
