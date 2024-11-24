<?php

namespace App\Utils\FormBuilder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Utils\FormBuilder\Fields\Field;

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
    public function addField(Field $field): self
    {
        $this->fields[] = $field;

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
        // Disable form caching in development environment.
        if (app()->environment('local')) {
            Cache::forget($this->getCacheKey());
        }

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

    /**
     * Builds a form with the specified parameters and fields.
     *
     * @return string rendered form HTML.
     */
    public static function build(
        string $name,
        array $fields,
        string $btnText,
        ?string $method = null,
        ?string $route = null,
    ): string {
        if (! $route) {
            $route = url()->current();
        }

        if (! $method) {
            $method = Request::METHOD_GET;
        }

        $formBuilder = new self(name: $name, method: $method, route: $route);

        foreach ($fields as $field) {
            $formBuilder->addField($field);
        }

        // foreach ($fields as $key => $options) {
        //     $formBuilder->addField(
        //         name: $key,
        //         type: $options['type'] ?? 'text',
        //         options: $options,
        //     );
        // }

        return $formBuilder->withButtonText(text: $btnText)->render();
    }

    protected function getCacheKey(): string
    {
        return 'form_builder:'.md5(serialize($this->fields).$this->buttonText);
    }
}
