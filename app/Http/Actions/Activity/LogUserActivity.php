<?php

namespace App\Http\Actions\Activity;

use App\Enums\Activity\ActivityEventType;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class LogUserActivity
{
    /**
     * Logs a user activity event by creating a new record in the activities table.
     */
    public function execute(
        User $user,
        Model $model,
        ActivityEventType $eventType,
    ): Activity {
        return $user->activities()->create([
            'event' => $eventType,
            'model_name' => class_basename($model),
            'table_name' => $model->getTable(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'data' => $model,
        ]);
    }
}
