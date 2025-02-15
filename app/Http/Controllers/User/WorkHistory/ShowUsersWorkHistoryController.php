<?php

namespace App\Http\Controllers\User\WorkHistory;

use App\Models\User;
use Illuminate\View\View;

final class ShowUsersWorkHistoryController
{
    public function __invoke(User $user): View
    {
        return view('resources.user.workHistory.show', [
            'user' => $user,
        ]);
    }
}
