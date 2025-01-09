<?php

namespace App\Http\Actions\WorkHistory;

use App\Models\WorkHistory;

final class DeleteWorkHistory
{
    public function execute(WorkHistory $workHistory): bool
    {
        return $workHistory->delete();
    }
}
