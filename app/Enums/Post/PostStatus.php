<?php

namespace App\Enums\Post;

enum PostStatus: string
{
    case PUBLISHED = 'published';

    case PENDING = 'pending';

    case DRAFT = 'draft';

    case ARCHIVED = 'archived';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
