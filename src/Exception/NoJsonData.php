<?php

namespace PHPJasper\Exception;

use Exception;

class NoJsonData extends Exception
{
    /**
     * No Json Data constructor.
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $message = 'No JSON data';
        parent::__construct($message, $code, $previous);
    }
}
