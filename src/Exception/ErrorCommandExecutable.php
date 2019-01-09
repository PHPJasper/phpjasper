<?php

namespace PHPJasper\Exception;

use Exception;

class ErrorCommandExecutable extends Exception
{
    /**
     * ErrorCommandExecutable constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $message = trim($message);

        if ($message === '') {
            $message = 'Your report has an error and couldn \'t be processed!\ Try to output the command using the function `output();` and run it manually in the console.';
        } else {
            $message = 'Your report has an error and couldn \'t be processed!\ Try to output the command using the function `output();` and run it manually in the console. Error of the command: ' . $message;
        }

        parent::__construct($message, $code, $previous);
    }
}
