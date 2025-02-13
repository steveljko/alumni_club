<?php

namespace App\Http\Actions\Post;

use App\Enums\Activity\ActivityEventType;
use App\Enums\Post\PostType;
use App\Http\Actions\Activity\LogUserActivity;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class UpdatePost
{
    public function execute(Post $post, array $data): void
    {
        DB::transaction(function () use ($post, $data) {
            $post = match ($post->type) {
                PostType::DEFAULT => $this->updateDefaultPost($post, $data),
                PostType::EVENT => $this->updateEventPost($post, $data),
                PostType::JOB => $this->updateJobPost($post, $data),
            };

            $this->logActivity(model: $post);
        });
    }

    private function updateDefaultPost(Post $post, array $data): Post
    {
        $post->default()->update($data);

        return $post;
    }

    private function updateEventPost(Post $post, array $data): Post
    {
        $post->event()->update($data);

        return $post;
    }

    private function updateJobPost(Post $post, array $data): Post
    {
        $post->job()->update($data);

        return $post;
    }

    private function logActivity(Model $model): void
    {
        (new LogUserActivity)->execute(
            user: auth()->user(),
            model: $model,
            eventType: ActivityEventType::UPDATE,
        );
    }
}
