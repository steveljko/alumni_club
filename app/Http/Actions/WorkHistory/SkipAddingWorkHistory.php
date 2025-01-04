<?php

namespace App\Http\Actions\WorkHistory;

use App\Models\User;

final class SkipAddingWorkHistory
{
    public function execute(User $user): bool
    {
        return $user->update(['setup_progress' => 'completed']);
    }
}
