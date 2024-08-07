<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\CreatePostService;
use App\Http\Resources\PostResource;
use Knuckles\Scribe\Attributes\Group;

#[Group('Post')]
class CreatePostController extends Controller
{
    /**
     * Create post
     *
     * @authenticated
     */
    public function __invoke(
        Request $request,
        CreatePostService $service
    ): JsonResponse {
        $post = $service(data: $request->all(), type: $request->type);

        return new JsonResponse(new PostResource($post), Response::HTTP_CREATED);
    }
}
