<?php

namespace App\Http\Controllers\User\WorkHistory;

use App\Enums\Auth\AccountSetupProgress;
use App\Http\Actions\WorkHistory\CreateWorkHistory;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkHistory\CreateWorkHistoryRequest;
use Illuminate\Http\Response;

final class CreateWorkHistoryController extends Controller
{
    public function __invoke(CreateWorkHistoryRequest $request, CreateWorkHistory $createWorkHistory): Response
    {
        $isDraft = auth()->user()->setup_progress != AccountSetupProgress::COMPLETED->value;

        $ok = $createWorkHistory->execute(
            request: $request,
            user: auth()->user(),
            is_draft: $isDraft,
        );

        if (! $ok) {
            return $this->toast(__('setup.step3.try_again'));
        }

        return $this->trigger(event: 'loadWorkHistories');
    }
}
