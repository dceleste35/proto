<?php

namespace Agicom\Sweepbright\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Agicom\Sweepbright\Sweepbright
 */
class Sweepbright extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Agicom\Sweepbright\Sweepbright::class;
    }
}
