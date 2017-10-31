<?php

namespace PHPJasper\Exception;

use Exception;

class InvalidFormat extends Exception
{
    /**
     * InvalidFormat constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
