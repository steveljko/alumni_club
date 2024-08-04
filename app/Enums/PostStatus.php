<?php

namespace App\Enums;

enum PostStatus: string
{
    public const PUBLISHED = 'published';

    public const PENDING = 'pending';

    public const DRAFT = 'draft';

    public const ARCHIVED = 'archived';
}
