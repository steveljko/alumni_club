<?php

namespace App\Http\Controllers\Api\Jobs;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Jobs\CreateJobRequest;

#[Group('Jobs')]
class CreateJobController extends Controller
{
    /**
     * Create job
     *
     * This endpoint is used for creating job for authenticated user.
     *
     * @authenticated
     *
     * @var \App\Http\Requests\Jobs\CreateJobRequest
     */
    public function __invoke(CreateJobRequest $request): JsonResponse
    {
        $createdJob = Auth::user()
            ->jobs()
            ->create($request->validated());

        Log::info('Job with ID {jobId} is successfully created by user ID {userId}', ['jobId' => $createdJob->id, 'userId' => Auth::user()->id]);

        return $this->sendCreated(data: $createdJob);
    }
}
