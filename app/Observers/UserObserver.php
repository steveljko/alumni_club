<?php

namespace App\Observers;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserObserver
{
    /**
     * Create details relation when user is created.
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

        $role = Role::findOrCreate('default');
        $user->assignRole($role);
    }
}
