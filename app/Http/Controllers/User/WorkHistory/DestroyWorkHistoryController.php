<?php

namespace App\Http\Controllers\User\WorkHistory;

use App\Http\Actions\WorkHistory\DeleteWorkHistory;
use App\Http\Controllers\Controller;
use App\Models\WorkHistory;
use Illuminate\Http\Response;

final class DestroyWorkHistoryController extends Controller
{
    public function __invoke(
        WorkHistory $workHistory,
        DeleteWorkHistory $deleteWorkHistory
    ): Response {
        if (! auth()->user()->can('delete', [$workHistory])) {
            return $this->toast(__('setup.step3.cant_delete'));
        }

        $ok = $deleteWorkHistory->execute(workHistory: $workHistory);

        if (! $ok) {
            return $this->toast(__('setup.step3.try_again'));
        }

        return $this->triggerWithToast(
            event: 'loadWorkHistories',
            message: __('setup.step3.can_delete')
        );
    }
}
