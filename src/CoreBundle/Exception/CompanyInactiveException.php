<?php

namespace MyTour\CoreBundle\Exception;

use Exception;

class CompanyInactiveException extends Exception
{
    public function __construct($message = "A empresa não está ativa.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}