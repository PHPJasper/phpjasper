<?php
namespace JasperPHP\Exception;
/**
 * Class InvalidCommandExecutable
 * @package JasperPHP\Exception
 */
class InvalidCommandExecutable extends \Exception
{

    /**
     * InvalidCommandExecutable constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $message = 'Cannot execute a blank command';
        parent::__construct($message, $code, $previous);
    }
}