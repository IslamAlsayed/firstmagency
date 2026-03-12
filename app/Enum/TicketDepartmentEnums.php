<?php

namespace App\Enum;

enum TicketDepartmentEnums: string
{
    case SALES = 'sales';
    case SUPPORT = 'support';
    case GENERAL = 'general';

    // return badge color
    public function badgeColor(): string
    {
        return match ($this) {
            self::SALES => 'bg-orange-600',
            self::SUPPORT => 'bg-green-600',
            self::GENERAL => 'bg-gray-600',
            default => 'bg-gray-600',
        };
    }

    // return icon class for department
    public function iconClass(): string
    {
        return match ($this) {
            self::SALES => 'fas fa-shopping-cart text-orange-600',
            self::SUPPORT => 'fas fa-headset text-green-600',
            self::GENERAL => 'fas fa-envelope text-gray-600',
            default => 'fas fa-question text-gray-600',
        };
    }
}
