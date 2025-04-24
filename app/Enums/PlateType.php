<?php

namespace App\Enums;

enum PlateType: string
{
    case CLASSIC = 'classic';
    case MODERN = 'modern';

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }
}