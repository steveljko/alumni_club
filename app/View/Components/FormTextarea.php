<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormTextarea extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $label,
        public ?int $limit,
        public ?string $value
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-textarea', [
            'name' => $this->name,
            'labe' => $this->label,
            'limit' => $this->limit,
            'value' => $this->value ?: '',
        ]);
    }
}
