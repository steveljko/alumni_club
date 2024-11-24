<?php

namespace App\Utils\FormBuilder\Fields;

class Select extends Field
{
    public string $type = 'select';

    public function __construct(
        public string $name,
        public string $label,
        public string $placeholder,
        public array $options,
    ) {
        parent::__construct(name: $name, type: $this->type, label: $label);
    }

    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
