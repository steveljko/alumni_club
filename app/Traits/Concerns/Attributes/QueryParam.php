<?php

namespace App\Traits\Concerns\Attributes;

use Attribute;

#[Attribute]
class QueryParam
{
    public function __construct(
        public string $value,
    ) {}
}
