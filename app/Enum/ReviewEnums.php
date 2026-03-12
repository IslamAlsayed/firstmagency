<?php

namespace App\Enum;

enum ReviewEnums: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    // return class badge color
    public function badgeColor(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-600',
            self::APPROVED => 'bg-green-600',
            self::REJECTED => 'bg-red-600',
            default => 'bg-gray-600',
        };
    }
}