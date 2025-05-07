<?php

namespace App\Enums;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case CANCELLED = 'cancelled';
    case EXPIRED = 'expired';
    case PENDING = 'pending';

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }
}