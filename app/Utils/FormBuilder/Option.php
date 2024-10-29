<?php

namespace App\Utils\FormBuilder;

class Option
{
    public function __construct(
        public string $value,
        public string $name
    ) {
        $this->value = $value;
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // TODO: Create function that can generate options for select based on enum
    public static function fromEnum() {}
}
