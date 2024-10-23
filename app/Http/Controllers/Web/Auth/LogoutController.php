<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Support\Facades\Auth;

class LogoutController
{
    public function __invoke()
    {
        Auth::guard('web')->logout();

        return redirect()->to('/login');
    }
}
