<?php

namespace App\Http\Controllers\Work;

final class ShowWorkHistoryController
{
    public function __invoke()
    {
        $work = auth()->user()->workHistory()->orderBy('created_at', 'desc')->get();

        if (request()->hasHeader('HX-Request')) {
            return view('auth.setup.add_work_history', compact('work'))
                ->fragments(['job_count', 'workHistories']);
        }

        return view('auth.setup.add_work_history', compact('work'));
    }
}
