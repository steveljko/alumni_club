<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Activity;
use Illuminate\View\View;

final class ShowActivityController
{
    public function __invoke(Activity $activity): View
    {
        return view('resources.dashboard.activities.show', compact('activity'));
    }
}
