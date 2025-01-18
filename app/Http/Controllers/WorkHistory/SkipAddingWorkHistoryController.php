<?php

namespace App\Http\Controllers\WorkHistory;

use App\Http\Actions\WorkHistory\SkipAddingWorkHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

final class SkipAddingWorkHistoryController extends Controller
{
    public function __invoke(SkipAddingWorkHistory $skipAddingWorkHistory): Response
    {
        $ok = $skipAddingWorkHistory->execute(user: auth()->user());

        if (! $ok) {
            return $this->toast(__('setup.step3.try_again'));
        }

        return $this->redirectWithToast(
            route: 'home',
            message: __('setup.step3.finish')
        );
    }
}
