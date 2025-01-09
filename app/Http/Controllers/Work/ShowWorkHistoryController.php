<?php

namespace App\Http\Controllers\Work;

use Illuminate\View\View;

final class ShowWorkHistoryController
{
    public function __invoke(): View
    {
        $work = auth()->user()->workHistory()->orderBy('created_at', 'desc')->get();
        $view = view('auth.setup.add_work_history', compact('work'));

        if (request()->hasHeader('HX-Request')) {
            return $view->fragments(['job_count', 'workHistories']);
        }

        return $view;
    }
}
