<?php

namespace Illuminate\Support\Facades;

/**
 * @see \Illuminate\Routing\Redirector
 */
class Settings extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'settings';
    }
}