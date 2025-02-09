<?php

namespace App\Http\Controllers\Post;

use App\Http\Actions\Post\DeletePost;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Response;

final class DestroyPostController extends Controller
{
    public function __invoke(
        Post $post,
        DeletePost $deletePost
    ): Response {
        if (! auth()->user()->can('delete', $post)) {
            return $this->trigger('Permission denied!');
        }

        $ok = $deletePost->execute($post);

        if (! $ok) {
            return $this->toast('asdasdsada');
        }

        return $this->triggerWithToast(event: 'reloadPosts', message: 'Successfully deleted!');
    }
}
