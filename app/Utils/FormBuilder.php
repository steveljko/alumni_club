<?php

namespace App\Utils;

class FormBuilder
{
    protected array $fields = [];

    public function __construct(
        public string $method,
        public string $route,
    ) {
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

    public function render(): string
    {
        $html = '<form method="'.$this->method.'" action="'.$this->route.'">';
        $html .= csrf_field();

        foreach ($this->fields as $field) {
            $html .= $this->renderField($field);
        }

        $html .= '<button type="submit">Submit</button>';
        $html .= '</form>';

        return $html;
    }

    protected function renderField($field): string
    {
        $html = '<div class="mb-4">';
        $error = session('errors') ? session('errors')->first($field['name']) : null;

        if (isset($field['options']['label'])) {
            $html .= '<label
                class="uppercase text-sm font-semibold"
                for="'.$field['name'].'">'.$field['options']['label'].'</label>';
        }

        switch ($field['type']) {
            case 'text':
                $html .= '<input type="text" name="'.$field['name'].'"';
                if (isset($field['options']['type'])) {
                    $html .= ' placeholder="'.$field['options']['placeholder'].'"';
                }
                if (isset($field['options']['placeholder'])) {
                    $html .= ' placeholder="'.$field['options']['placeholder'].'"';
                }
                $html .= 'value="'.old($field['name']).'" class="block">';
                if ($error) {
                    $html .= '<div class="text-red-500">'.$error.'</div>';
                }
                break;
            case 'textarea':
                $html .= '<textarea name="'.$field['name'].'"></textarea>';
                break;
            case 'select':
                $html .= '<select name="'.$field['name'].'">';
                foreach ($field['options']['choices'] as $value => $label) {
                    $html .= '<option value="'.$value.'">'.$label.'</option>';
                }
                $html .= '</select>';
                break;
        }

        $html .= '</div>';

        return $html;
    }
}
