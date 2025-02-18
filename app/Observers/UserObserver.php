<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Cache::forget('dashboard_stats');

        $user->assignRole('alumni');
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $post): void
    {
        Cache::forget('dashboard_stats');
    }
}
