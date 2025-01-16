<?php

namespace App\Http\Actions\WorkHistory;

use App\Http\Requests\UpdateWorkHistoryRequest;
use App\Models\WorkHistory;

final class UpdateWorkHistory
{
    public function execute(
        WorkHistory $workHistory,
        UpdateWorkHistoryRequest $request
    ): bool {
        return $workHistory->update([
            'company_name' => $request->company_name,
            'position' => $request->position,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'is_draft' => false,
        ]);
    }
}
