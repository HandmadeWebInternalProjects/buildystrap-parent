<?php

namespace Buildystrap\Cache;

use Buildystrap\Builder;
use Buildystrap\Builder\Extends\Module;
use Spatie\Blink\Blink;

class GlobalModuleCache extends AbstractBlinkCache
{
    protected static Blink $blink;

    public static function get(int $global_id): ?Module
    {
        if (static::blink()->has($global_id)) {
            return static::blink()->get($global_id);
        }

        $global = Builder::getGlobalModule($global_id);
        static::blink()->put($global_id, $global);

        return $global;
    }
}
