<?php

namespace Buildystrap\Cache;

use Spatie\Blink\Blink;

abstract class AbstractBlinkCache
{
    public static function blink(string $store = 'default'): Blink
    {
        if (empty(static::$blink[$store])) {
            static::$blink[$store] = new Blink();
        }

        return static::$blink[$store];
    }
}
