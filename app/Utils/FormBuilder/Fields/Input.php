<?php

namespace App\Utils\FormBuilder\Fields;

class Input extends Field
{
    public array $allowedTypes = ['text', 'number', 'email', 'password'];

    public string $type = 'input';

    public function __construct(
        public string $name,
        public string $label,
        public string $placeholder,
        public string $inputType,
    ) {
        parent::__construct(name: $name, type: $this->type, label: $label);

        if (! in_array($inputType, $this->allowedTypes)) {
            throw new \InvalidArgumentException("Invalid input type: '$inputType'. Allowed types are 'text', 'number', 'email' and 'password'.");
        }

        $this->inputType = $inputType;
        $this->placeholder = $placeholder;
    }

    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    public function getInputType(): string
    {
        return $this->inputType;
    }
}
