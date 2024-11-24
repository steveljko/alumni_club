<?php

namespace App\Utils\FormBuilder\Fields;

class Field
{
    public function __construct(
        public string $name,
        public string $type,
        public string $label,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function hasLabel(): bool
    {
        return ! empty($this->label);
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getPreviousValue(): ?string
    {
        $parts = explode('[', $this->getName());
        $name = trim($parts[0]);
        $filterType = isset($parts[1]) ? trim(rtrim($parts[1], ']')) : '';

        return request()->query($name)[$filterType] ?? null;
    }
}
