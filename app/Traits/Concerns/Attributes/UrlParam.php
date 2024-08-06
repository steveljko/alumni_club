<?php

namespace App\Traits\Concerns\Attributes;

use Attribute;

#[Attribute]
class UrlParam
{
    public function __construct(
        public string $value,
    ) {
    }
}
