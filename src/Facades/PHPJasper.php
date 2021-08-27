<?php
namespace PHPJasper\Facades;

use Illuminate\Support\Facades\Facade;

class PHPJasper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'geekcom.phpjasper';
    }
}