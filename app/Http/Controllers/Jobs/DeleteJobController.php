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
            return $this->sendUnauthorized();
        }

        try {
            $job->delete();

            Log::info('User with ID {userId} successfully delete Job with ID {jobId}', ['userId' => Auth::user()->id, 'jobId' => $job->id]);

            return $this->sendOk();
        } catch (\Exception $ex) {
            Log::warning('User with ID {userId} failed to delete Job with ID {jobId}.', ['userId' => Auth::user()->id, 'jobId' => $job->id]);

            return $this->sendForbidden();
        }
    }
}
