<?php

namespace App\Http\Controllers\WorkHistory;

use App\Models\WorkHistory;
use Illuminate\View\View;

final class EditWorkHistoryController
{
    public function __invoke(WorkHistory $workHistory): View
    {
        return view('resources.user.workHistory.edit', compact('workHistory'));
    }
}
