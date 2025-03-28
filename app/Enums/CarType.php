<?php

namespace App\Enums;

enum CarType:int{

    case MANUAL = 0;
    case AUTOMATIC = 1;

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }

}