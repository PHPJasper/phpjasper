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
     * @param array $output
     *
     */
    public function __construct($message = "", $code = 0, Exception $previous = null, $output = [])
    {
        $message = '';

        foreach ($output as $line) {
            $message .= $line . '   ';
        }

        if (empty($message)) {
            $message = 'Your report has an error and couldn\'t be processed! Try to output the command using the function `output();` and run it manually in the console.';
        }

        parent::__construct($message, $code, $previous);
    }
}
