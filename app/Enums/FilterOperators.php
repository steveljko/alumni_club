<?php

namespace App\Enums;

enum FilterOperators: string
{
    case EQUALS = 'eq';

    case LESS_THAN = 'lt';

    case LESS_THAN_EQUALS = 'lte';

    case GRATER_THAN = 'gt';

    case GRATER_THAN_EQUALS = 'gte';
}
