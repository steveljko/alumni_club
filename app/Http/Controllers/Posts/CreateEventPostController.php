<?php

namespace App\Http\Controllers\Posts;

use App\Services\CreatePost;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Posts\CreateEventPostRequest;

// TODO: Create thumbnail image uploading
#[Group('Post')]
class CreateEventPostController extends Controller
{
    /**
     * Create event post
     *
     * @authenticated
     */
    public function __invoke(
        CreateEventPostRequest $request,
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
