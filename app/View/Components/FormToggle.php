<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormToggle extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $label,
        public ?string $placeholder,
        public ?string $value,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.toggle', [
            'name' => $this->name,
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'value' => $this->value,
        ]);
    }
}
