<?php

namespace App\Http\Controllers\Posts;

use App\Services\CreatePost;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Posts\CreateJobPostRequest;

#[Group('Post')]
class CreateJobPostController extends Controller
{
    /**
     * Create job post
     *
     * @authenticated
     */
    public function __invoke(
        CreateJobPostRequest $request,
        CreatePost $service,
    ): JsonResponse {
        $data = $request->validated();

        $post = $service($data);

        return $this->sendResponse(
            data: new PostResource($post),
            status: Response::HTTP_CREATED
        );
    }
}
