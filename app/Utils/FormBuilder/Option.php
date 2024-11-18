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

    /**
     * Generate options from a range of years,
     * used for generating a year range.
     */
    public static function fromYearRange(int $from, ?int $to = null): array
    {
        if ($to === null) {
            $to = (int) date('Y');
        }

        return array_map(function ($year) {
            return new Option(value: (string) $year, name: (string) $year);
        }, range($from, $to));
    }
}
