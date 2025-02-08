<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, ?Comment $comment): bool
    {
        if ($user->can('edit any post')) {
            return true;
        }

        if ($user->can('edit own post')) {
            return $comment->user_id === $user->id;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, ?Comment $comment): bool
    {
        if ($user->can('delete any post')) {
            return true;
        }

        if ($user->can('delete own post')) {
            return $comment->user_id === $user->id;
        }
    }
}
