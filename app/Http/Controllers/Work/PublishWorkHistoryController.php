<?php

namespace App\Http\Controllers\Work;

use App\Http\Actions\WorkHistory\PublishWorkHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

final class PublishWorkHistoryController extends Controller
{
    public function __invoke(PublishWorkHistory $publishWorkHistory): Response
    {
        $ok = $publishWorkHistory->execute(user: auth()->user());

        if (! $ok) {
            return $this->toast(__('setup.step3.try_again'));
        }

        return $this->redirectWithToast(
            route: 'home',
            message: __('setup.step3.finish'),
        );
    }
}
