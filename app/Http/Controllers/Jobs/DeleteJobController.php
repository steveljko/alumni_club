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

            return $this->sendOk();
        } catch (\Exception $ex) {
            return $this->sendForbidden();
        }
    }
}
