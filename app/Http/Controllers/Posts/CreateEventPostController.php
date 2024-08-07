<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Posts\CreateEventPostRequest;

#[Group('Post')]
class CreateEventPostController extends Controller
{
    // TODO: Create thumbnail image uploading
    public function __invoke(
        CreateEventPostRequest $request
    ): JsonResponse {
        $data = $request->validated();

        $postData = Arr::only($data, ['status', 'type']);
        $eventData = Arr::except($data, ['status', 'type']);

        $post = Post::create($postData + ['user_id' => auth()->user()->id]);
        $post->event()->create($eventData);
        $post->load('event');

        return $this->sendResponse(
            data: new PostResource($post),
            status: Response::HTTP_CREATED
        );
    }
}
