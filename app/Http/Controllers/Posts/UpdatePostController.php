<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Services\UpdatePost;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;

#[Group('Posts')]
class UpdatePostController extends Controller
{
    /**
     * Update post
     *
     * This endpoint is used for updating post by using their id.
     * It accepts a type, then validates the fields using validation for this post type.
     * It accepts the same fields as post creation.
     *
     * @authenticated
     */
    public function __invoke(
        Post $post,
        UpdatePost $service
    ): JsonResponse {
        if (! Auth::user()->owns(model: $post)) {
            return $this->sendUnauthorized();
        }

        try {
            $service(post: $post);

            return $this->sendOk(data: new PostResource($post));
        } catch (\Exception $e) {
            return $this->sendForbidden();
        }
    }
}
