<?php

namespace App\Http\Controllers\WorkHistory;

use Illuminate\View\View;

final class ShowWorkHistoryController
{
    public function __invoke(): View|string
    {
        $workHistory = auth()->user()
            ->workHistory()
            ->orderBy('start_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $view = view('resources.user.workHistory.show', compact('workHistory'));

        if (request()->hasHeader('HX-Request')) {
            return $view->fragments(['job_count', 'workHistories']);
        }

        return $view;
    }
}
