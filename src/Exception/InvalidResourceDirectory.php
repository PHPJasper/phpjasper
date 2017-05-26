<?php
namespace PHPJasper\Exception;
/**
 * Class InvalidResourceDirectory
 * @package PHPJasper\Exception
 */
class InvalidResourceDirectory extends \Exception
{

    /**
     * Invalid Resource Directory constructor.
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $message = 'Invalid resource directory';
        parent::__construct($message, $code, $previous);
    }
}