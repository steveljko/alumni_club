<?php

namespace App\Http\Actions\Auth;

use App\Enums\Activity\ActivityEventType;
use App\Http\Actions\Activity\LogUserActivity;

final class UserLogout
{
    public function __construct(private LogUserActivity $logUserActivity) {}

    public function execute(): void
    {
        $this->logUserActivity->execute(user: auth()->user(), model: auth()->user(), eventType: ActivityEventType::LOGOUT);

        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
