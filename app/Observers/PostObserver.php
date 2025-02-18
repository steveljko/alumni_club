<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        Cache::forget("user_stats:{$post->user->id}");
        Cache::forget('dashboard_stats');
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        Cache::forget("user_stats:{$post->user->id}");
        Cache::forget('dashboard_stats');
    }
}
