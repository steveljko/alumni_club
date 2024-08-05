<?php

namespace App\Enums;

enum PostType: string
{
    case DEFAULT = 'default';

    case EVENT = 'event';

    case JOB = 'job';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
