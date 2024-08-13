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
            return $this->sendUnauthorized();
        }

        try {
            $job->update($request->validated());

            return $this->sendOk(data: new JobResource($job));
        } catch (\Exception $ex) {
            return $this->sendForbidden();
        }
    }
}
