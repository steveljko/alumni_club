<?php

namespace App\Http\Controllers\User\WorkHistory;

use Illuminate\View\View;

final class ShowAddWorkHistoryStepController
{
    public function __invoke(): View
    {
        $workHistory = auth()->user()
            ->workHistory()
            ->get();

        return view('resources.auth.setup.add_work_history', compact('workHistory'));
    }
}
