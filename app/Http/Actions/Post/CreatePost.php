<?php

namespace App\Http\Actions\Post;

use App\Enums\Activity\ActivityEventType;
use App\Enums\Post\PostStatus;
use App\Enums\Post\PostType;
use App\Http\Actions\Activity\LogUserActivity;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class CreatePost
{
    public function execute(PostType $type, array $data)
    {
        DB::transaction(function () use ($type, $data) {
            $post = Post::create([
                'status' => PostStatus::PUBLISHED,
                'type' => $type,
                'user_id' => auth()->user()->id,
            ]);

            $post = match ($type) {
                PostType::DEFAULT => $this->createDefaultPost($post, $data),
                PostType::EVENT => $this->createEventPost($post, $data),
                PostType::JOB => $this->createJobPost($post, $data),
            };

            $this->logActivity(model: $post);
        });
    }

    private function createDefaultPost(Post $post, array $data): Post
    {
        $post->default()->create($data);
        $post->load('default');

        return $post;
    }

    private function createEventPost(Post $post, array $data): Post
    {
        $post->event()->create($data);
        $post->load('event');

        return $post;
    }

    private function createJobPost(Post $post, array $data): Post
    {
        $post->job()->create($data);
        $post->load('job');

        return $post;
    }

    private function logActivity(Model $model): void
    {
        (new LogUserActivity)->execute(
            user: auth()->user(),
            model: $model,
            eventType: ActivityEventType::CREATE,
        );
    }
}
