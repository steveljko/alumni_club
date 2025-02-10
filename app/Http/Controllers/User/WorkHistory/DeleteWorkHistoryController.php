<?php

namespace App\Http\Controllers\User\WorkHistory;

use App\Models\WorkHistory;
use Illuminate\View\View;

final class DeleteWorkHistoryController
{
    public function __invoke(WorkHistory $workHistory): View
    {
        return view('resources.user.workHistory.delete', compact('workHistory'));
    }
}
