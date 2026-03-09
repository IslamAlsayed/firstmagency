<?php

namespace App\Enum;

enum ArticleEnums: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
}
