<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class EditUserController
{
    public function __invoke(Request $request, User $user): View
    {
        return view('resources.dashboard.users.edit', compact('user'));
    }
}
