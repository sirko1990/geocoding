<?php

namespace Geocoding;

use Illuminate\Support\Facades\Facade;

class GeocodingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'geocoding';
    }
}