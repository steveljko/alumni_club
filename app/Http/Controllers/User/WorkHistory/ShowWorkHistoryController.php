<?php

namespace App\Http\Controllers\User\WorkHistory;

use Illuminate\Http\Request;
use Illuminate\View\View;

final class ShowWorkHistoryController
{
    public function __invoke(Request $request): View
    {
        $workHistory = auth()->user()
            ->workHistory()
            ->orderBy('start_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('resources.user.workHistory.show', compact('workHistory'));
    }
}
