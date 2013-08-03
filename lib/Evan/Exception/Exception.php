<?php

namespace Evan\Exception;

class Exception extends \RuntimeException
{
    public function __construct($message = 'Access Denied', \Exception $previous = null)
    {
        parent::__construct($message, 403, $previous);
    }
}
