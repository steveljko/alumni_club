<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Services\CreatePost;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Posts\CreateEventPostRequest;

#[Group('Posts')]
class CreateEventPostController extends Controller
{
    /**
     * Create event post
     *
     * This endpoint allows authenticated users to create an event post.
     *
     * @authenticated
     */
    public function __invoke(
        CreateEventPostRequest $request,
        CreatePost $createPost,
    ): JsonResponse {
        $data = $request->validated();

        $post = $createPost($data);

        return $this->sendCreated(data: new PostResource($post));
    }
}
