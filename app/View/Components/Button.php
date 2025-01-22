<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $id,
        public string $style = 'normal',
        public string $type = 'button',
        public string $size = 'md',
        public bool $spinner = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button', [
            'id' => $this->id,
            'style' => $this->style,
            'type' => $this->type,
            'size' => $this->size,
            'id' => $this->spinner,
        ]);
    }
}
