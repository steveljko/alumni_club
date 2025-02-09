<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can edit the model.
     */
    public function edit(?User $user, ?Post $post): bool
    {
        if ($user->can('edit any post')) {
            return true;
        }

        if ($user->can('edit own post')) {
            return $post->user_id === $user->id;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, ?Post $post): bool
    {
        if ($user->can('delete any post')) {
            return true;
        }

        if ($user->can('delete own post')) {
            return $post->user_id === $user->id;
        }
    }
}
