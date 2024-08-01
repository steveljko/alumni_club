<?php

namespace App\Http\Controllers\Jobs;

use App\Models\UserJobs;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\JobResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Jobs\UpdateJobRequest;

#[Group('Jobs')]
class UpdateJobController extends Controller
{
    /**
     * Update job
     *
     * This endpoint is used for updating job by using their id.
     *
     * @authenticated
     *
     * @var \App\Http\Requests\Jobs\UpdateJobRequest
     * @var \App\Models\UserJobs
     */
    public function __invoke(
        UpdateJobRequest $request,
        UserJobs $job,
    ): JsonResponse {
        if (! Auth::user()->owns(model: $job)) {
            return $this->sendFailResponse(
                message: __('additional.jobs.failed_update')
            );
        }

        $updated = $job->update($request->validated());

        if ($updated) {
            return $this->sendResponse(
                message: __('additional.jobs.successful_update'),
                data: new JobResource($job),
            );
        }

        return $this->sendFailResponse(
            message: __('additional.jobs.failed_update')
        );

    }
}
