<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Requests\CreateJobRequest;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

#[Group('Jobs')]
class CreateJobController extends Controller
{
  /**
   * Create job
   *
   * This endpoint is used for creating job for authenticated user.
   *
   * @authenticated
   */
  public function __invoke(CreateJobRequest $request): JsonResponse
  {
    $createdJob = Auth::user()
      ->jobs()
      ->create($request->validated());

    return $this->sendResponse(
      message: __('additional.job.successful_create'),
      data: $createdJob,
      status: Response::HTTP_CREATED,
    );
  }
}
