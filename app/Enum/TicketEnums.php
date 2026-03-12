<?php

namespace App\Enum;

enum TicketEnums: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case PROCESSED = 'processed';
    case REPLIED = 'replied';
    case CLOSED = 'closed';

    // return class badge color
    public function badgeColor(): string
    {
        return match ($this) {
            self::OPEN => 'bg-yellow-600',
            self::IN_PROGRESS => 'bg-blue-600',
            self::PROCESSED => 'bg-violet-600',
            self::REPLIED => 'bg-green-600',
            self::CLOSED => 'bg-red-600',
            default => 'bg-gray-600',
        };
    }

    // return icon class for status
    public function iconClass(): string
    {
        return match ($this) {
            self::OPEN => 'fas fa-folder-open text-yellow-600',
            self::IN_PROGRESS => 'fas fa-spinner text-blue-600',
            self::PROCESSED => 'fas fa-chart-diagram text-violet-600',
            self::REPLIED => 'fas fa-check text-green-600',
            self::CLOSED => 'fas fa-times text-red-600',
            default => 'fas fa-question text-gray-600',
        };
    }
}
