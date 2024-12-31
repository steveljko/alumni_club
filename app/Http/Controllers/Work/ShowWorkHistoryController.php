<?php

namespace App\Http\Controllers\Work;

use Illuminate\View\View;

final class ShowWorkHistoryController
{
    public function __invoke(): View
    {
        $work = auth()->user()->workHistory()->orderBy('created_at', 'desc')->get();

        return view('auth.setup.add_work_history', compact('work'));
    }
}
