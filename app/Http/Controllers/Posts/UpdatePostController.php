<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Services\UpdatePost;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

class UpdatePostController extends Controller
{
    public function __invoke(
        Post $post,
        UpdatePost $service
    ): JsonResponse {
        // TODO: Check ownership

        $updatedPost = $service($post);

        return $this->sendResponse(
            data: new PostResource($updatedPost)
        );
    }
}
