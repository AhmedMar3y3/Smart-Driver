<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $message;

    public function __construct($message = "Subscription failed")
    {
        $this->message = $message;
        parent::__construct($this->message);
    }
}