<?php

namespace App\Utils\FormBuilder;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class FormBuilder
{
    protected array $fields = [];

    protected string $buttonText;

    public function __construct(
        public string $name,
        public string $method,
        public string $route,
    ) {
        $this->name = $name.'Form';
        $this->method = $method;
        $this->route = $route;
    }

    /**
     * @param  array<int,mixed>  $options
     */
    public function addField(
        string $name,
        string $type = 'text',
        array $options = [],
    ): self {
        $this->fields[] = [
            'name' => $name,
            'type' => $type,
            'options' => $options,
        ];

        return $this;
    }

    public function addPrimaryField(string $name): self
    {
        $this->fields[] = [
            'name' => $name,
            'type' => 'hidden',
            'options' => [],
        ];

        return $this;
    }

    /**
     * Set submit button text
     *
     * @var string
     */
    public function withButtonText(string $text): self
    {
        $this->buttonText = $text;

        return $this;
    }

    /**
     * Render form
     *
     * @var string
     */
    public function render(): string
    {
        return Cache::rememberForever($this->getCacheKey(), function () {
            return View::make('form', [
                'name' => $this->name,
                'method' => $this->method,
                'route' => $this->route,
                'fields' => $this->fields,
                'buttonText' => $this->buttonText,
            ])->render();
        });
    }

    protected function getCacheKey(): string
    {
        return 'form_builder:'.md5(serialize($this->fields).$this->buttonText);
    }
}
