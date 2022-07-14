<?php

namespace Buildystrap;

use Buildystrap\Builder;

class BuilderCacher
{
    protected static array $globals = [];
    protected static array $render = [];

    public static function get(int $global_id)
    {
        if ( ! empty(static::$globals[$global_id])) {
            return static::$globals[$global_id];
        }

        return static::$globals[$global_id] = Builder::getGlobalModule($global_id);
    }

    public static function render(int $global_id)
    {
        if ( ! empty(static::$render[$global_id])) {
            return static::$render[$global_id];
        }

        return static::$render[$global_id] = static::get($global_id)->render();
    }
}
