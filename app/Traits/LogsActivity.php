<?php

namespace App\Traits;

use App\Enums\Activity\ActivityEventType;
use App\Http\Actions\Activity\LogUserActivity;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        $user = auth()->user();

        static::created(function ($model) use ($user) {
            if (DatabaseSeeder::isRunning()) {
                $user = User::find($model->user_id);
            }

            (new LogUserActivity)->execute(user: $user, model: $model, eventType: ActivityEventType::CREATE);
        });

        static::updating(function ($model) use ($user) {
            if (DatabaseSeeder::isRunning()) {
                $user = User::find($model->user_id);
            }

            (new LogUserActivity)->execute(user: $user, model: $model, eventType: ActivityEventType::UPDATE);
        });

        static::deleting(function ($model) use ($user) {
            if (DatabaseSeeder::isRunning()) {
                $user = User::find($model->user_id);
            }

            (new LogUserActivity)->execute(user: $user, model: $model, eventType: ActivityEventType::DELETE);
        });
    }
}
