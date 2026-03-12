<?php

namespace App\Enum;

enum WhyUsEnums: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';

    // return class badge color
    public function badgeColor(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-gray-600',
            self::PUBLISHED => 'bg-green-600',
            default => 'bg-gray-600',
        };
    }
}
