<?php

namespace App\Enums;

enum Status:int{

    case PENDING = 0;
    case SOLD = 1;

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }

}