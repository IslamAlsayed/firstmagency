<?php

namespace App\Enum;

enum ArticleEnums: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    // return class badge color
    public function badgeColor(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-gray-600',
            self::PUBLISHED => 'bg-green-600',
            self::ARCHIVED => 'bg-red-600',
            default => 'bg-gray-600',
        };
    }
}
