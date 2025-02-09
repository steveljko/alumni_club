<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSelect extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $label,
        public ?string $value,
        public ?string $between
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.select', [
            'name' => $this->name,
            'options' => $this->generateDate(),
            'value' => $this->value,
        ]);
    }

    /**
     * Generates dates between range of dates
     */
    private function generateDate(): array
    {
        [$start, $end] = explode(',', $this->between);

        if ($end == 'current') {
            $end = date('Y');
        }

        $dates = [];

        for ($year = $start; $year <= $end; $year++) {
            $dates[] = $year;
        }

        return [null, ...$dates];
    }
}
