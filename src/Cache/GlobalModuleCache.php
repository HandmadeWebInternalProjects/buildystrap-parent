<?php

namespace Buildystrap\Cache;

class GlobalModuleCache extends AbstractBlinkCache
{
    public static function get(int $global_id)
    {
        if (static::blink()->has($global_id)) {
            return static::blink()->get($global_id);
        }

        $global = Builder::getGlobalModule($global_id);
        static::blink()->put($global_id, $global);

        return $global;
    }
}
