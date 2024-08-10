<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Arr;

class CreatePost
{
    public function __invoke(array $data): Post
    {
        $postData = Arr::only($data, ['status', 'type']);
        $relationData = Arr::except($data, ['status', 'type']);

        $post = Post::create($postData + ['user_id' => auth()->user()->id]);

        switch ($data['type']) {
            case 'default':
                $post->default()->create($relationData);
                $post->load('default');
                break;
            case 'event':
                $post->event()->create($relationData);
                $post->load('event');
                break;
            case 'job':
                $post->job()->create($relationData);
                $post->load('job');
                break;
        }

        return $post;
    }
}
