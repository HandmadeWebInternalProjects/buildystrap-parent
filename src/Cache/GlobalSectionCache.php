<?php

namespace Buildystrap\Cache;

use Buildystrap\Builder;
use Buildystrap\Builder\Layout\Container;

class GlobalSectionCache extends AbstractBlinkCache
{
    protected static array $blink = [];

    public static function get(int $global_id): ?Container
    {
        if ($global = static::blink()->get($global_id)) {
            return $global;
        }

        $global = Builder::getGlobal($global_id);
        static::blink()->put($global_id, $global);

        return $global;
    }
}
