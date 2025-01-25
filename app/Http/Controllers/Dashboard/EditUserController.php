<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\View\View;

final class EditUserController
{
    public function __invoke(User $user): View
    {
        return view('resources.dashboard.users.edit', compact('user'));
    }
}
