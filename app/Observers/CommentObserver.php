<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        Redis::hincrby("user_stats:$comment->user_id", 'comments', 1);
        Cache::forget('dashboard_stats');
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        Cache::forget('dashboard_stats');
    }
}
