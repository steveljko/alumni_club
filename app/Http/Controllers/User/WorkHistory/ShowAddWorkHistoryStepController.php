<?php

namespace App\Http\Controllers\User\WorkHistory;

use Illuminate\View\View;

final class ShowAddWorkHistoryStepController
{
    public function __invoke(): View
    {
        $workHistory = auth()->user()
            ->workHistory()
            ->orderBy('start_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('resources.auth.setup.add_work_history', compact('workHistory'));
    }
}
