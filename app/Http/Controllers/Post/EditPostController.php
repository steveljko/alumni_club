<?php

namespace App\Http\Controllers\Post;

use App\Enums\Post\PostType;
use App\Models\Post;
use Illuminate\View\View;

final class EditPostController
{
    public function __invoke(Post $post): View
    {
        return match ($post->type) {
            PostType::DEFAULT => view('resources.post.edit_default', compact('post')),
            PostType::EVENT => view('resources.post.edit_event', compact('post')),
            PostType::JOB => view('resources.post.edit_job', compact('post')),
        };
    }
}
