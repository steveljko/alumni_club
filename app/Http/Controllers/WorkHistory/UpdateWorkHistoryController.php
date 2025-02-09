<?php

namespace App\Http\Controllers\WorkHistory;

use App\Http\Actions\WorkHistory\UpdateWorkHistory;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateWorkHistoryRequest;
use App\Models\WorkHistory;
use Illuminate\Http\Response;

final class UpdateWorkHistoryController extends Controller
{
    public function __invoke(
        UpdateWorkHistoryRequest $request,
        WorkHistory $workHistory,
        UpdateWorkHistory $updateWorkHistory
    ): Response {
        $ok = $updateWorkHistory->execute(workHistory: $workHistory, request: $request);

        if (! $ok) {
            $this->toast(__('auth.try_again'));
        }

        return $this->triggerWithToast(
            event: 'reloadWorkHistories',
            message: __('auth.workHistory.update_success')
        );
    }
}
