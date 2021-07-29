<?php

namespace Mindwingx\Dpas\Facades;

use Illuminate\Support\Facades\Facade;

class Dpas extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dpas';
    }
}
