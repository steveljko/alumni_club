<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Services\CreatePost;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\Posts\CreateEventPostRequest;

#[Group('Post')]
class CreateEventPostController extends Controller
{
    /**
     * Create event post
     *
     * @authenticated
     */
    public function __invoke(
        CreateEventPostRequest $request,
        CreatePost $createPost,
    ): JsonResponse {
        $data = $request->validated();

        $post = $createPost($data);

        if ($image = $request->file('thumbnail_image')) {
            $path = $image->store('images', 'public');

            $post->event->thumbImage()->create([
                'path' => $path,
                'type' => 'thumbnail_image',
                'uploaded_by' => Auth::id(),
            ]);

            $post->event->load('thumbImage');
        }

        return $this->sendCreated(data: new PostResource($post));
    }
}
