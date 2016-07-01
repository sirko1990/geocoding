<?php

namespace Geocoding;

use \Exception;

class GeocodingException extends Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}