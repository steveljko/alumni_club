<?php

namespace App\Http\Controllers\Api\Posts;

use App\Models\Post;
use App\Services\UpdatePost;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Resources\Posts\PostResource;

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
            Log::warning('User with ID {userId} tried to update Post with ID {postId}, but doesn\'t have permission', ['userId' => Auth::user()->id, 'postId' => $post->id]);

            return $this->sendUnauthorized();
        }

        try {
            $service(post: $post);

            Log::info('User with ID {userId} successfully updated Post with ID {postId}.', ['userId' => Auth::user()->id, 'postId' => $post->id]);

            return $this->sendOk(data: new PostResource($post));
        } catch (\Exception $e) {
            Log::warning('User with ID {userId} failed to updated Post with ID {postId}.', ['userId' => Auth::user()->id, 'postId' => $post->id]);

            return $this->sendForbidden();
        }
    }
}
