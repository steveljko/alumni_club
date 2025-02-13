<?php

namespace App\Http\Actions\Post;

use App\Enums\Activity\ActivityEventType;
use App\Http\Actions\Activity\LogUserActivity;
use App\Models\Post;

final class DeletePost
{
    public function execute(Post $post): bool
    {
        $ok = $post->delete();

        (new LogUserActivity)->execute(user: auth()->user(), model: $post, eventType: ActivityEventType::DELETE);

        return $ok;
    }
}
