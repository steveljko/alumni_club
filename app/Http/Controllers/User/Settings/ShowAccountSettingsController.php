<?php

namespace App\Http\Controllers\User\Settings;

use Illuminate\View\View;

final class ShowAccountSettingsController
{
    public function __invoke(): View
    {
        $user = auth()->user()->load(['workHistory' => function ($query) {
            $query->orderBy('start_date', 'desc')
                ->orderBy('created_at', 'desc');
        }]);

        return view('resources.user.profile.settings', compact('user'));
    }
}
