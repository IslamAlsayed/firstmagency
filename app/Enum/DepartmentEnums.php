<?php

namespace App\Enum;

enum DepartmentEnums: string
{
    case TECHNICAL_SUPPORT = 'technical-support';
    case SALES = 'sales';
    case BILLING = 'billing';
    case COMPLAINTS = 'complaints';

    // return class badge color
    public function badgeColor(): string
    {
        return match ($this) {
            self::TECHNICAL_SUPPORT => 'bg-blue-600 text-white',
            self::SALES => 'bg-green-600 text-white',
            self::BILLING => 'bg-yellow-600 text-white',
            self::COMPLAINTS => 'bg-red-600 text-white',
            default => 'bg-gray-600 text-white',
        };
    }

    // return bg, border and color css styles
    public function badgeStyle(): string
    {
        return match ($this) {
            self::TECHNICAL_SUPPORT => 'bg-blue-100 border-blue-600 text-blue-800',
            self::SALES => 'bg-green-100 border-green-600 text-green-800',
            self::BILLING => 'bg-yellow-100 border-yellow-600 text-yellow-800',
            self::COMPLAINTS => 'bg-red-100 border-red-600 text-red-800',
            default => 'bg-gray-100 border-gray-600 text-gray-800',
        };
    }
}
