<?php

namespace App\Traits\Concerns\Enums;

use App\Traits\Concerns\Attributes\UrlParam;
use App\Traits\Concerns\Attributes\QueryParam;

enum FilterOperators
{
    #[UrlParam('eq')]
    #[QueryParam('=')]
    case EQUALS;

    #[UrlParam('lt')]
    #[QueryParam('<')]
    case LESS_THAN;

    #[UrlParam('lte')]
    #[QueryParam('<=')]
    case LESS_THAN_EQUALS;

    #[UrlParam('gt')]
    #[QueryParam('>')]
    case GRATER_THAN;

    #[UrlParam('gte')]
    #[QueryParam('>=')]
    case GRATER_THAN_EQUALS;

    #[UrlParam('lk')]
    #[QueryParam('like')]
    case LIKE;

    public function getUrlParam(): string
    {
        return $this->getAttributeValue(UrlParam::class);
    }

    public function getQueryParam(): string
    {
        return $this->getAttributeValue(QueryParam::class);
    }

    private function getAttributeValue(string $attributeClass): string
    {
        $reflection = new \ReflectionEnum($this);
        $case = $reflection->getCase($this->name);

        foreach ($case->getAttributes($attributeClass) as $attribute) {
            return $attribute->newInstance()->value;
        }

        throw new \LogicException("Attribute not found for case {$this->name}");
    }
}
