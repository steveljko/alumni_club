<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Services\UpdatePost;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;

class UpdatePostController extends Controller
{
    public function __invoke(
        Post $post,
        UpdatePost $service
    ): JsonResponse {
        if (! Auth::user()->owns($post)) {
            return $this->sendFailResponse(
                message: 'Unauthorized',
                status: Response::HTTP_UNAUTHORIZED
            );
        }

        $updatedPost = $service($post);

        return $this->sendResponse(
            data: new PostResource($updatedPost)
        );
    }
}
