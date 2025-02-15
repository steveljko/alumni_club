<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkHistoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WorkHistory $workHistory): bool
    {
        if ($user->can('edit any work history')) {
            return true;
        }

        if ($user->can('edit own work history')) {
            return $workHistory->user_id === $user->id;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, ?WorkHistory $workHistory): bool
    {
        if ($user->can('delete any work history')) {
            return true;
        }

        if ($user->can('delete own work history')) {
            return $workHistory->user_id === $user->id;
        }
    }
}
