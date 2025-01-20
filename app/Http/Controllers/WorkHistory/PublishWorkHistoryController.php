<?php

namespace App\Http\Controllers\WorkHistory;

use App\Http\Actions\WorkHistory\PublishWorkHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

final class PublishWorkHistoryController extends Controller
{
    public function __invoke(PublishWorkHistory $publishWorkHistory): Response
    {
        $status = $publishWorkHistory->execute(user: auth()->user());

        switch ($status) {
            case PublishWorkHistory::PUBLISHED_AND_STATUS_CHANGED:
                return $this->redirectWithToast(
                    route: 'home',
                    message: __('setup.step3.finish'),
                );
            case PublishWorkHistory::PUBLISHED:
                return $this->redirectWithToast(
                    route: 'auth.settings',
                    message: 'Published successfully.',
                );
            case PublishWorkHistory::ERROR:
                return $this->toast(__('setup.step3.try_again'));
        }
    }
}
