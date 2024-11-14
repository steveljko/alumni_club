<?php

namespace App\Utils\FormBuilder;

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
        $html = <<<HTML
            <form id="{$this->name}" data-method="{$this->method}" data-action="{$this->route}">
            <div id="errors"></div>
        HTML;

        foreach ($this->fields as $field) {
            $html .= $this->renderField($field);
        }

        $btnText = $this->buttonText ?: 'Submit';
        $html .= <<<HTML
            <button class="w-full px-2 py-1 bg-blue-700 rounded">{$btnText}</button>
            </form>
        HTML;

        return $html;
    }

    /**
     * Render form fields
     *
     * @var string
     */
    protected function renderField(array $field): string
    {
        $name = $field['name'];
        $options = $field['options'];

        $label = $options['label'] ?? '';
        $placeholder = $options['placeholder'] ?? '';
        $inputType = $options['inputType'] ?? 'text';
        $oldVal = old($name);

        $html = '<div class="mb-4">';

        if ($label) {
            $html .= <<<HTML
            <label class="uppercase text-sm font-semibold" for="{$name}">{$label}</label>
            HTML;
        }

        switch ($field['type']) {
            // Render text input field
            case 'text':
                $html .= <<<HTML
                <input
                    name="{$name}"
                    type="{$inputType}"
                    placeholder="{$placeholder}"
                    value="{$oldVal}"
                    class="block"
                />
                HTML;
                break;

                // Render select with options
            case 'select':
                $html .= "<select name=\"{$name}\" class=\"block\">";
                if ($label) {
                    $html .= "<option selected disabled>{$label}</option>";
                }
                foreach ($options['options'] as $option) {
                    $html .= "<option value=\"{$option->getValue()}\">{$option->getName()}</option>";
                }
                $html .= '</select>';
                break;

                // Render hidden field (used for id)
            case 'hidden':
                $html .= "<input type=\"hidden\" name=\"{$name}\" value=\"{$oldVal}\">";
                break;
        }

        if ($name !== 'id') {
            $html .= "<div id=\"error-$name\" class=\"block mt-2 text-sm text-red-500\"></div>";
        }

        $html .= '</div>';

        return $html;
    }
}
