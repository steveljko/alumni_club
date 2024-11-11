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
        $html = "<form id=\"$this->name\" data-method=\"$this->method\" data-action=\"$this->route\">";
        $html .= "<div id='errors'></div>";

        foreach ($this->fields as $field) {
            $html .= $this->renderField($field);
        }

        $btnText = $this->buttonText ? $this->buttonText : 'Submit';
        $html .= "<button class=\"w-full px-2 py-1 bg-blue-700 rounded\">$btnText</button>";
        $html .= '</form>';

        return $html;
    }

    /**
     * Render form fields
     *
     * @var string
     */
    // FIX: Placeholder
    protected function renderField(array $field): string
    {
        $html = '<div class="mb-4">';

        $f = $field;
        $name = $f['name'];
        $o = $field['options'];

        if (isset($o['label'])) {
            $html .= "<label class=\"uppercase text-sm font-semibold\" for=\"{$name}\}\">{$o['label']}</label>";
        }

        switch ($field['type']) {
            case 'text':
                $inputType = isset($o['inputType']) ? $o['inputType'] : 'text';
                $oldVal = old($name);

                $html .= "<input
                    name=\"{$name}\"
                    type=\"{$inputType}\"
                    placeholder=\"{$o['placeholder']}\"
                    value=\"{$oldVal}\"
                    class=\"block\"
                />";
                break;
            case 'select':
                $html .= "<select name=\"{$name}\" class=\"block\">";

                if (isset($o['label'])) {
                    $html .= "<option selected disabled>{$o['label']}</option>";
                }
                foreach ($o['options'] as $option) {
                    $html .= "<option value=\"{$option->getValue()}\">{$option->getName()}</option>";
                }

                $html .= '</select>';
                break;
        }

        $html .= "<div id=\"error-$name\" class=\"text-red-500\"></div>";

        $html .= '</div>';

        return $html;
    }
}
