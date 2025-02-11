<?php

namespace App\Http\Actions\WorkHistory;

use App\Enums\Auth\AccountSetupProgress;
use App\Models\User;

final class SkipAddingWorkHistory
{
    public function execute(User $user): bool
    {
        return $user->update(['setup_progress' => AccountSetupProgress::COMPLETED]);
    }
}
