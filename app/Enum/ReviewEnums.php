<?php

namespace App\Enum;

enum ReviewEnums: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}