<?php

namespace App\Traits;

use App\Enums\Activity\ActivityEventType;
use App\Http\Actions\Activity\LogUserActivity;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        $user = auth()->user();

        static::created(function ($model) use ($user) {
            (new LogUserActivity)->execute(user: $user, model: $model, eventType: ActivityEventType::CREATE);
        });

        static::updating(function ($model) use ($user) {
            (new LogUserActivity)->execute(user: $user, model: $model, eventType: ActivityEventType::UPDATE);
        });

        static::deleting(function ($model) use ($user) {
            (new LogUserActivity)->execute(user: $user, model: $model, eventType: ActivityEventType::DELETE);
        });
    }
}
