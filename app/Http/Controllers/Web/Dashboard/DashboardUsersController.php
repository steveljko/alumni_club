<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DashboardUsersController
{
    public function __invoke(Request $request): View
    {
        $users = User::with('details');

        if ($request->query('name')) {
            $users->where('name', 'LIKE', '%'.$request->name.'%');
        }

        if ($request->query('uni_start_year')) {
            $users->whereHas('details', function ($query) use ($request) {
                return $query->where('uni_start_year', $request->uni_start_year);
            });
        }

        $users = $users->paginate(10)->appends(request()->query());

        return view('dashboard/users', compact('users'));
    }
}
