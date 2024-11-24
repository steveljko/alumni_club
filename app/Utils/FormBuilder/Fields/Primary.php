<?php

namespace App\Utils\FormBuilder\Fields;

class Primary extends Field
{
    public string $type = 'primary';

    public function __construct(
        public string $name,
    ) {
        parent::__construct(name: $name, type: $this->type, label: '');
    }
}
