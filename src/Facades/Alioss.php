<?php

namespace Siaoynli\LaravelAliOSS\Facades;


use Illuminate\Support\Facades\Facade;


class Alioss extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'alioss';
    }
}
