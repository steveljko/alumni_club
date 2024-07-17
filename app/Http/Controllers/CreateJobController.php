<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\CreateJobRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Knuckles\Scribe\Attributes\Group;

#[Group('Jobs')]
class CreateJobController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return ['auth:sanctum'];
  }

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
