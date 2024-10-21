<?php

namespace App\Http\Controllers\Api\Posts;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;

#[Group('Posts')]
class DeletePostController extends Controller
{
    /**
     * Delete post by ID
     *
     *
     *
     * @authenticated
     */
    public function __invoke(Post $post): JsonResponse
    {
        if (! Auth::user()->owns(model: $post)) {
            Log::warning('User with ID {userId} tried to delete Post with ID {postId}, but doesn\'t have permission', ['userId' => Auth::user()->id, 'postId' => $post->id]);

            return $this->sendUnauthorized();
        }

        try {
            $post->delete();

            Log::warning('User with ID {userId} successfully deleted Post with ID {postId}', ['userId' => Auth::user()->id, 'postId' => $post->id]);

            return $this->sendOk();
        } catch (\Exception $ex) {
            return $this->sendForbidden();
        }
    }
}
