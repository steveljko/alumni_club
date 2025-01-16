<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;

final class ShowAccountSettingsController
{
    public function __invoke(): View
    {
        $user = auth()->user()->load('workHistory');

        return view('auth.settings', compact('user'));
    }
}
