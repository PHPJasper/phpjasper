<?php
namespace PHPJasper\Exception;
/**
 * Class InvalidFormat
 * @package PHPJasper\Exception
 */
class InvalidFormat extends \Exception
{

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}