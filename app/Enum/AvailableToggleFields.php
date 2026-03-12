<?php

namespace App\Enum;

enum AvailableToggleFields: string
{
    case IS_ACTIVE = 'is_active';
    case IS_FEATURED = 'is_featured';

    // return class badge color
    public function badgeColor(): string
    {
        return match ($this) {
            self::IS_ACTIVE => 'bg-green-600',
            self::IS_FEATURED => 'bg-pink-600',
            default => 'bg-gray-600',
        };
    }
}
