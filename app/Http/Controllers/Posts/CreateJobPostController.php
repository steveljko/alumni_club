<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Posts\CreateJobPostRequest;

#[Group('Post')]
class CreateJobPostController extends Controller
{
    /**
     * Create job post
     *
     * @authenticated
     */
    public function __invoke(
        CreateJobPostRequest $request
    ): JsonResponse {
        $data = $request->validated();

        $postData = Arr::only($data, ['status', 'type']);
        $jobData = Arr::except($data, ['status', 'type']);

        $post = Post::create($postData + ['user_id' => auth()->user()->id]);
        $post->job()->create($jobData);
        $post->load('job');

        return $this->sendResponse(
            data: new PostResource($post),
            status: Response::HTTP_CREATED
        );
    }
}
