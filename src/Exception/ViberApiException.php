<?php

namespace AvpLab\ViberApi\Exception;

class ApiException extends \Exception
{
    public function __construct($code, $message, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}