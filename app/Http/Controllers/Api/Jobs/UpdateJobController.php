<?php

namespace App\Http\Controllers\Api\Jobs;

use App\Models\UserJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Resources\Jobs\JobResource;
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
            Log::warning('User with ID {userId} tried to update Job with ID {jobId}, but doesn\'t have permission', ['userId' => Auth::user()->id, 'jobId' => $job->id]);

            return $this->sendUnauthorized();
        }

        try {
            $job->update($request->validated());

            Log::info('User with ID {userId} successfully update Job with ID {jobId}.', ['userId' => Auth::user()->id, 'jobId' => $job->id]);

            return $this->sendOk(data: new JobResource($job));
        } catch (\Exception $ex) {
            Log::warning('User with ID {userId} failed to update Job with ID {jobId}.', ['userId' => Auth::user()->id, 'jobId' => $job->id]);

            return $this->sendForbidden();
        }
    }
}
