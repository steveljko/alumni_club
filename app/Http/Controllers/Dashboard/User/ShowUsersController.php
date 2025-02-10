<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ShowUsersController
{
    public function __invoke(Request $request): View|string
    {
        $searchTerm = $request->input('q');

        $users = User::where('name', 'LIKE', "%$searchTerm%")
            ->paginate(10);

        if ($request->header('hx-request')) {
            return view('resources.dashboard.users.page', compact('users'))
                ->fragment('table');
        }

        return view('resources.dashboard.users.page', compact('users'));
    }
}
