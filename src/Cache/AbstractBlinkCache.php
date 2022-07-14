<?php

namespace Buildystrap\Cache;

use Spatie\Blink\Blink;

abstract class AbstractBlinkCache
{
    protected static Blink $blink;

    public static function blink(): Blink
    {
        if ( ! static::$blink instanceof Blink) {
            static::$blink = new Blink();
        }

        return static::$blink;
    }
}
