<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

final class RedirectController
{
    public function __invoke(): View
    {
        $url = urldecode(request()->query('url'));

        return view('resources.redirect', compact('url'));
    }
}
