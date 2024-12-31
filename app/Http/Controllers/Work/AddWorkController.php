<?php

namespace App\Http\Controllers\Work;

use App\Http\Requests\AddWorkHistoryRequest;

final class AddWorkController
{
    public function __invoke(AddWorkHistoryRequest $request): void
    {
        $user = auth()->user();

        $user->workHistory()->create($request->validated());
    }
}
