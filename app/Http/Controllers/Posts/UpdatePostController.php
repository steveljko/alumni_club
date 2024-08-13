<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Services\UpdatePost;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;

#[Group('Post')]
class UpdatePostController extends Controller
{
    /**
     * Update post
     *
     * This endpoint is used for updating post by using their id.
     *
     * @authenticated
     */
    public function __invoke(
        Post $post,
        UpdatePost $service
    ): JsonResponse {
        if (! Auth::user()->owns(model: $post)) {
            return $this->sendFailResponse(
                message: __('additional.posts.failed_update'),
                status: Response::HTTP_UNAUTHORIZED
            );
        }

        $updated = $service(post: $post);

        if ($updated) {
            return $this->sendResponse(
                message: __('additional.posts.successful_update'),
                data: new PostResource($post)
            );
        }

        return $this->sendFailResponse(message: __('additional.posts.failed_update'));
    }
}
