<?php

namespace App\Http\Controllers\Jobs;

use Illuminate\Http\JsonResponse;
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

        return $this->sendCreated(data: $createdJob);
    }
}
