<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        Cache::forget("user_stats:{$comment->user->id}");
        Cache::forget('dashboard_stats');
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        Cache::forget("user_stats:{$comment->user->id}");
        Cache::forget('dashboard_stats');
    }
}
