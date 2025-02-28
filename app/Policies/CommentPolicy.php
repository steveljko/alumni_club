<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can edit the model.
     */
    public function edit(?User $user, ?Comment $comment): bool
    {
        return $user->can('edit any comment') || $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, ?Comment $comment): bool
    {
        if ($user->can('edit any comment')) {
            return true;
        }

        if ($user->can('edit own comment')) {
            return $comment->user_id === $user->id;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, ?Comment $comment): bool
    {
        if ($user->can('delete any comment')) {
            return true;
        }

        if ($user->can('delete own comment')) {
            return $comment->user_id === $user->id;
        }
    }
}
