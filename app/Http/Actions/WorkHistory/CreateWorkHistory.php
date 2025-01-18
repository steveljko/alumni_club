<?php

namespace App\Http\Actions\WorkHistory;

use App\Http\Requests\WorkHistory\CreateWorkHistoryRequest;
use App\Models\User;
use App\Models\WorkHistory;

final class CreateWorkHistory
{
    public function execute(
        CreateWorkHistoryRequest $request,
        User $user,
        bool $is_draft = false
    ): WorkHistory {
        return $user->workHistory()->create(array_merge($request->validated() + ['is_draft' => $is_draft]));
    }
}
