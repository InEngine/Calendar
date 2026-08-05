<?php

namespace InEngine\Calendar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \InEngine\Calendar\Calendar
 */
class Calendar extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \InEngine\Calendar\Calendar::class;
    }
}
