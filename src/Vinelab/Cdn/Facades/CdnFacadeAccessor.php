<?php namespace Vinelab\Cdn\Facades;

use Illuminate\Support\Facades\Facade;

class CdnFacadeAccessor extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cdn';
    }
}
