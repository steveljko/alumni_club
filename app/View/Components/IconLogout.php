<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class IconLogout extends Component
{
    public function render(): View
    {
        return view('components.icons.logout');
    }
}
