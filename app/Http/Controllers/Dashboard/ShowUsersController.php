<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\View\View;

final class ShowUsersController
{
    public function __invoke(): View
    {
        $users = User::paginate(10);

        if (request()->header('hx-request')
            && request()->header('hx-target') == 'users-table') {
            return view('dashboard.users.partials.table', compact('users'));
        }

        return view('dashboard.users.page', compact('users'));
    }
}
