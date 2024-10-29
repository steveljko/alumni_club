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

    /**
     * Generate options based on enum
     */
    public static function fromEnum($enumClass): array
    {
        if (! enum_exists($enumClass)) {
            throw new \InvalidArgumentException('The provided class is not an enum.');
        }

        $options = [];
        foreach ($enumClass::cases() as $case) {
            $options[] = new self($case->value, ucfirst(strtolower($case->name)));
        }

        return $options;
    }
}
