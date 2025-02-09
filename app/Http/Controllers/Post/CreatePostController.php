<?php

namespace App\Http\Controllers\Post;

use App\Enums\Post\PostType;
use App\Http\Actions\Post\CreatePost;
use App\Http\Controllers\Controller;
use App\Http\Requests\BaseFormRequest;
use App\Http\Requests\Post\CreateDefaultPostRequest;
use App\Http\Requests\Post\CreateEventPostRequest;
use App\Http\Requests\Post\CreateJobPostRequest;
use Illuminate\Http\Response;

final class CreatePostController extends Controller
{
    public function __invoke(
        PostType $type,
        BaseFormRequest $baseRequest,
        CreatePost $createPost
    ): Response {
        $request = match ($type) {
            PostType::DEFAULT => $baseRequest->convertRequest(CreateDefaultPostRequest::class),
            PostType::EVENT => $baseRequest->convertRequest(CreateEventPostRequest::class),
            PostType::JOB => $baseRequest->convertRequest(CreateJobPostRequest::class),
        };

        // Run validation
        $request->validateResolved();

        $post = $createPost->execute(
            type: $type,
            data: $request->all()
        );

        return $this->triggerWithToast(
            event: 'reloadPosts',
            message: 'Post is created.'
        );
    }
}
