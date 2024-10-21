<?php

namespace App\Http\Controllers\Api\Posts;

use App\Models\Post;
use App\Services\CreatePost;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Resources\Posts\PostResource;
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

        Log::info('User with ID {userId} successfully created new Event Post with ID {postId}', ['userId' => Auth::User()->id, 'postId' => $post->id]);

        return $this->sendCreated(data: new PostResource($post));
    }
}
