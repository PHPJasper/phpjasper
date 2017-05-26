<?php
namespace PHPJasper\Exception;
/**
 * Class ErrorCommandExecutable
 * @package PHPJasper\Exception
 */
class ErrorCommandExecutable extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $message = 'Your report has an error and couldn \'t be processed!\ Try to output the command using the function `output();` and run it manually in the console.';
        parent::__construct($message, $code, $previous);
    }
}