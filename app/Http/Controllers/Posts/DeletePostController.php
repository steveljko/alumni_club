<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;

#[Group('Post')]
class DeletePostController extends Controller
{
    public function __invoke(Post $post): JsonResponse
    {
        if (! Auth::user()->owns(model: $post)) {
            return $this->sendUnauthorized();
        }

        try {
            $post->delete();

            return $this->sendOk();
        } catch (\Exception $ex) {
            return $this->sendForbidden();
        }
    }
}
