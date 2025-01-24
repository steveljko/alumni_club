<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;

final class ShowAddWorkHistoryStepController
{
    public function __invoke(): View
    {
        return view('resources.auth.setup.add_work_history', ['workHistory' => auth()->user()->workHistory]);
    }
}
