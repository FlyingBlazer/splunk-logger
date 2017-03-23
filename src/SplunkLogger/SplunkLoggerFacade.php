<?php

namespace SplunkLogger;

use Illuminate\Support\Facades\Facade;

class SplunkLoggerFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'SplunkLogger';
    }
}
