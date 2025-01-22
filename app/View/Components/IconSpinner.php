<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class IconSpinner extends Component
{
    public function render(): View
    {
        return view('components.icons.spinner');
    }
}
