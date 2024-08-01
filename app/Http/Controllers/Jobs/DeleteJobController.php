<?php

namespace App\Http\Controllers\Jobs;

use App\Models\UserJobs;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;

#[Group('Jobs')]
class DeleteJobController extends Controller
{
    /**
     * Delete job
     *
     * This endpoint is used for deleting job using their id.
     *
     * @authenticated
     *
     * @param  \App\Http\Models\UserJobs  $job
     */
    public function __invoke(UserJobs $job): JsonResponse
    {
        if (! Auth::user()->owns(model: $job)) {
            return $this->sendFailResponse(
                message: __('additional.jobs.failed_delete')
            );
        }

        $deleted = $job->delete();

        if (! $deleted) {
            return $this->sendFailResponse(
                message: __('additional.jobs.failed_delete')
            );
        }

        return $this->sendResponse(
            message: __('additional.jobs.successful_delete'),
        );
    }
}
