<?php

namespace App\Enums;

enum Subscription:int{

    case FREE = 0;
    case PAID = 1;

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }

}