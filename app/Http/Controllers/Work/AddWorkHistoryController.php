<?php

namespace App\Http\Controllers\Work;

use App\Http\Actions\WorkHistory\AddWorkHistory;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddWorkHistoryRequest;
use Illuminate\Http\Response;

final class AddWorkHistoryController extends Controller
{
    public function __invoke(AddWorkHistoryRequest $request, AddWorkHistory $addWorkHistory): Response
    {
        $ok = $addWorkHistory->execute(request: $request, user: auth()->user());

        if (! $ok) {
            return $this->toast(__('setup.step3.try_again'));
        }

        return $this->trigger(event: 'loadWorkHistories');
    }
}
