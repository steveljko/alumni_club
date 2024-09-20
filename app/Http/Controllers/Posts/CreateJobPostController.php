<?php

namespace App\Http\Controllers\Posts;

use App\Services\CreatePost;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
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

        return $this->sendCreated(data: new PostResource($post));
    }
}
