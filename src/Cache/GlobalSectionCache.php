<?php

namespace Buildystrap\Cache;

use Buildystrap\Builder;
use Buildystrap\Builder\Layout\Container;
use Spatie\Blink\Blink;

class GlobalSectionCache extends AbstractBlinkCache
{
    protected static Blink $blink;

    public static function get(int $global_id): ?Container
    {
        if (static::blink()->has($global_id)) {
            return static::blink()->get($global_id);
        }

        $global = Builder::getGlobal($global_id);
        static::blink()->put($global_id, $global);

        return $global;
    }
}
