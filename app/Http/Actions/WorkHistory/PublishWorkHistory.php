<?php

namespace App\Http\Actions\WorkHistory;

use App\Enums\Auth\AccountSetupProgress;
use App\Models\User;

final class PublishWorkHistory
{
    const PUBLISHED_AND_STATUS_CHANGED = 'published_and_status_changed';

    const PUBLISHED = 'published';

    const ERROR = 'error';

    public function execute(User $user): string
    {
        $ok = $user->workHistory()->update(['is_draft' => false]);

        if (! $ok) {
            return self::ERROR;
        }

        if ($ok) {
            if ($user->setup_progress != AccountSetupProgress::COMPLETED->value) {
                $user->update(['setup_progress' => AccountSetupProgress::COMPLETED->value]);

                return self::PUBLISHED_AND_STATUS_CHANGED;
            }

            return self::PUBLISHED;
        }
    }
}
