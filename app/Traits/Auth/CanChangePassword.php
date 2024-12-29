<?php

namespace App\Traits\Auth;

use Illuminate\Support\Facades\Hash;

trait CanChangePassword
{
    /**
     * Changes initial password
     */
    public function changeInitialPassword(string $password): bool
    {
        if ($this->isInitialPasswordChanged() == true) {
            return false;
        }

        $this->password = Hash::make($password);
        $this->initial_password_changed_at = now();
        $this->setup_progress = 'step.2';

        return $this->save();
    }

    /**
     * Determine if the initial password has been changed.
     */
    public function isInitialPasswordChanged(): bool
    {
        return $this->initial_password_changed_at != null;
    }
}
