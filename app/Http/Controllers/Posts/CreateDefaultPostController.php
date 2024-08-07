<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Posts\CreateDefaultPostRequest;

#[Group('Post')]
class CreateDefaultPostController extends Controller
{
    /**
     * Create default post
     *
     * @authenticated
     */
    public function __invoke(
        CreateDefaultPostRequest $request,
    ): JsonResponse {
        $data = $request->validated();

        $postData = Arr::only($data, ['status', 'type']);
        $defaultData = Arr::except($data, ['status', 'type']);

        $post = Post::create($postData + ['user_id' => auth()->user()->id]);
        $post->default()->create($defaultData);
        $post->load('default');

        return $this->sendResponse(
            data: new PostResource($post),
            status: Response::HTTP_CREATED
        );
    }
}
