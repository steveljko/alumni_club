<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Requests\Jobs\UpdateJobRequest;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use Illuminate\Http\JsonResponse;
use App\Models\UserJobs;

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
   * @var \App\Http\Requests\Jobs\UpdateJobRequest $request
   * @var \App\Models\UserJobs $job
   * @return \Illuminate\Http\JsonResponse
   */
  public function __invoke(
    UpdateJobRequest $request,
    UserJobs $job,
  ): JsonResponse
  {
    if (!Auth::user()->owns(model: $job)) {
      return $this->sendFailResponse(
        message: __('additional.job.failed_update')
      );
    }

    $updated = $job->update($request->validated());

    if ($updated) {
      return $this->sendResponse(
        message: __('additional.job.successful_update'),
        data: new JobResource($job),
      );
    } else {
      return $this->sendFailResponse(
        message: __('additional.job.failed_update')
      );
    }
  }
}
