<?php

namespace App\Http\Actions\WorkHistory;

use App\Http\Requests\AddWorkHistoryRequest;
use App\Models\User;
use App\Models\WorkHistory;

final class AddWorkHistory
{
    public function execute(AddWorkHistoryRequest $request, User $user): WorkHistory
    {
        return $user->workHistory()->create($request->validated());
    }
}
