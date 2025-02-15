<?php

namespace App\Http\Controllers\User\WorkHistory;

use Illuminate\Http\Request;
use Illuminate\View\View;

final class ShowWorkHistoryController
{
    public function __invoke(Request $request): View
    {
        $user = auth()->user()
            ->load('workHistory');

        return view('resources.user.workHistory.show', compact('user'));
    }
}
