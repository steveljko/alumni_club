<?php

namespace App\Http\Controllers\Post;

use App\Enums\Post\PostType;
use App\Http\Actions\Post\UpdatePost;
use App\Http\Controllers\Controller;
use App\Http\Requests\BaseFormRequest;
use App\Http\Requests\Post\UpdateDefaultPostRequest;
use App\Http\Requests\Post\UpdateEventPostRequest;
use App\Http\Requests\Post\UpdateJobPostRequest;
use App\Models\Post;
use Illuminate\Http\Response;

final class UpdatePostController extends Controller
{
    public function __invoke(
        Post $post,
        BaseFormRequest $baseRequest,
        UpdatePost $updatePost
    ): Response {
        if (! auth()->user()->can('edit', $post)) {
            return $this->trigger('Permission denied!');
        }

        $request = match ($post->type) {
            PostType::DEFAULT => $baseRequest->convertRequest(UpdateDefaultPostRequest::class),
            PostType::EVENT => $baseRequest->convertRequest(UpdateEventPostRequest::class),
            PostType::JOB => $baseRequest->convertRequest(UpdateJobPostRequest::class),
        };

        $request->validateResolved();

        $ok = $updatePost->execute(post: $post, data: $request->all());

        return $this->triggerWithToast(event: "reloadPost.$post->id", message: 'Successfully updated post!');
    }
}
