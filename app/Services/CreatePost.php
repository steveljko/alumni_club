<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CreatePost
{
    public function __invoke(array $data): Post
    {
        $postData = Arr::only($data, ['status', 'type']);
        $relationData = Arr::except($data, ['status', 'type']);

        $post = Post::create($postData + ['user_id' => Auth::id()]);

        switch ($data['type']) {
            case 'default':
                $this->createDefaultPost(post: $post, relationData: $relationData);
                break;
            case 'event':
                $this->createEventPost(post: $post, relationData: $relationData);
                break;
            case 'job':
                $this->createJobPost(post: $post, relationData: $relationData);
                break;
        }

        return $post;
    }

    private function createDefaultPost(
        Post $post,
        array $relationData
    ): void {
        $post->default()->create($relationData);
        $post->load('default');
    }

    private function createEventPost(
        Post $post,
        array $relationData
    ): void {
        $post->event()->create($relationData);
        $post->load('event');

        if ($image = $relationData['thumbnail_image'] ?? false) {
            $path = $image->store('images', 'public');

            $post->event->thumbImage()->create([
                'path' => $path,
                'type' => 'thumbnail_image',
                'uploaded_by' => Auth::id(),
            ]);
        }

        $post->event->load('thumbImage');
    }

    private function createJobPost(
        Post $post,
        array $relationData
    ): void {
        $post->job()->create($relationData);
        $post->load('job');
    }
}
