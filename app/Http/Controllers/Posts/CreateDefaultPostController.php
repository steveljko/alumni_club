<?php

namespace App\Http\Controllers\Posts;

use App\Services\CreatePost;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Resources\Posts\PostResource;
use App\Http\Requests\Posts\CreateDefaultPostRequest;

#[Group('Posts')]
class CreateDefaultPostController extends Controller
{
    /**
     * Create default post
     *
     * This endpoint allows authenticated users to create a default post.
     *
     * @authenticated
     */
    public function __invoke(
        CreateDefaultPostRequest $request,
        CreatePost $service,
    ): JsonResponse {
        $data = $request->validated();

        $post = $service($data);

        return $this->sendCreated(data: new PostResource($post));
    }
}
