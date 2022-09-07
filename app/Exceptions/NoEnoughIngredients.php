<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NoEnoughIngredients extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = "No enough ingredients available to order this quantity of ($message), try again later.";
        $code = 422;
        parent::__construct($message, $code, $previous);
    }
}
