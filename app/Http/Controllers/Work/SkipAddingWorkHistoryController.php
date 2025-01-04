<?php

namespace App\Http\Controllers\Work;

use App\Http\Actions\WorkHistory\SkipAddingWorkHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

final class SkipAddingWorkHistoryController extends Controller
{
    public function __invoke(SkipAddingWorkHistory $skipAddingWorkHistory): Response
    {
        $ok = $skipAddingWorkHistory->execute(user: auth()->user());

        if (! $ok) {
            return $this->toast('Something bad happend!');
        }

        return $this->redirectWithToast(
            route: 'home',
            message: 'You are good to go!'
        );
    }
}
