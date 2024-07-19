<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
      $user->details()->create([
        'date_of_birth' => null,
        'gender' => null,
        'phone_number' => null,
        'uni_start_year' => null,
        'uni_finish_year' => null,
        'bio' => null,
      ]);
    }
}
