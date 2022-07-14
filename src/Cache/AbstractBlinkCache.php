<?php

namespace Buildystrap\Cache;

use Spatie\Blink\Blink;

abstract class AbstractBlinkCache
{
    public static function blink(): Blink
    {
        if ( ! isset(static::$blink)) {
            static::$blink = new Blink();
        }

        return static::$blink;
    }
}
