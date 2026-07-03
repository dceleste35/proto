<?php

namespace Agicom\Telemaque\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Agicom\Telemaque\Telemaque
 */
class Telemaque extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Agicom\Telemaque\Telemaque::class;
    }
}
