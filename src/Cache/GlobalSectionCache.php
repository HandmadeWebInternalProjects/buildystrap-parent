<?php

namespace Buildystrap\Cache;

use Buildystrap\Builder;
use Buildystrap\Builder\Layout\Container;

use function optional;

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

    public static function render(int $global_id): string
    {
        if ($global = static::blink('render')->get($global_id)) {
            return $global;
        }

        $global = optional(static::get($global_id))->render() ?? '';

        static::blink('render')->put($global_id, $global);

        return $global;
    }
}
