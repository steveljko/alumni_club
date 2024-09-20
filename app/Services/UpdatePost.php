<?php

namespace App\Services;

use App\Models\Post;
use App\Http\Requests\Posts\UpdateJobPostRequest;
use App\Http\Requests\Posts\UpdateEventPostRequest;
use App\Http\Requests\Posts\UpdateDefaultPostRequest;

class UpdatePost
{
    public function __invoke(Post $post): Post
    {
        switch ($post->type->value) {
            case 'default':
                $request = app(UpdateDefaultPostRequest::class);
                $post->default()->update($request->validated());
                $post->load('default');

                return $post;
                break;
            case 'event':
                $request = app(UpdateEventPostRequest::class);
                $post->event()->update($request->validated());
                $post->load('event');

                return $post;
                break;
            case 'job':
                $request = app(UpdateJobPostRequest::class);
                $post->job()->update($request->validated());
                $post->load('job');

                return $post;
                break;
        }
    }
}
