<?php

namespace App\Enums;

enum PackageType: string
{
    case CAPTAIN = 'captain';
    case PLATE = 'plate';
    case CAR = 'car';

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }
}