<?php

namespace App\Http\Controllers\Post;

use App\Enums\Post\PostType;
use Illuminate\View\View;

final class GetPostFormController
{
    public function __invoke(PostType $type): View
    {
        return match ($type) {
            PostType::DEFAULT => view('resouces.post.create_default_form'),
            PostType::EVENT => view('resources.post.create_event_form'),
            PostType::JOB => view('resources.post.create_job_form'),
            default => throw new \InvalidArgumentException('Invalid post type provided.'),
        };
    }
}
