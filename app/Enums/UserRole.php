<?php

namespace App\Enums;

enum UserRole: string
{
    case DEFAULT = 'defualt';

    case ADMIN = 'admin';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
