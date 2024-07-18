<?php

namespace App\Http\Controllers\Jobs;

use Knuckles\Scribe\Attributes\Group;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\UserJobs;

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
   * @param \App\Http\Models\UserJobs $job
   * @return \Illuminate\Http\JsonResponse
   */
  public function __invoke(UserJobs $job): JsonResponse
  {
    if (!Auth::user()->owns(model: $job)) {
      return $this->sendFailResponse(
        message: __('additional.job.failed_delete')
      );
    }

    $deleted = $job->delete();

    if (!$deleted) {
      return $this->sendFailResponse(
        message: __('additional.job.failed_delete')
      );
    }

    return $this->sendResponse(
      message: __('additional.job.successful_delete'),
    );
  }
}
