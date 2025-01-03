<?php

namespace App\Http\Actions\WorkHistory;

use App\Models\User;

final class PublishWorkHistory
{
    public function execute(User $user): bool
    {
        $ok = $user->workHistory()->update(['is_draft' => false]);

        if ($ok) {
            $user->update(['setup_progress' => 'completed']);

            return $ok;
        }
    }
}
