<?php

namespace App\Http\Controllers\Api\Posts;

use App\Services\CreatePost;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Resources\Posts\PostResource;
use App\Http\Requests\Posts\CreateJobPostRequest;

#[Group('Posts')]
class CreateJobPostController extends Controller
{
    /**
     * Create job post
     *
     * This endpoint allows authenticated users to create an job post.
     *
     * @authenticated
     */
    public function __invoke(
        CreateJobPostRequest $request,
        CreatePost $service,
    ): JsonResponse {
        $data = $request->validated();

        $post = $service($data);

        Log::info('User with ID {userId} successfully created new Job Post with ID {postId}', ['userId' => Auth::User()->id, 'postId' => $post->id]);

        return $this->sendCreated(data: new PostResource($post));
    }
}
