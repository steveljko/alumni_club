<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ShowUsersController
{
    public function __invoke(Request $request): View
    {
        $searchTerm = $request->input('q');

        $users = User::where('name', 'LIKE', "%$searchTerm%")
            ->paginate(10);

        if ($request->header('hx-request')
            && $request->header('hx-target') == 'users-table') {
            return view('resources.dashboard.users.partials.table', compact('users'));
        }

        return view('resources.dashboard.users.page', compact('users'));
    }
}
