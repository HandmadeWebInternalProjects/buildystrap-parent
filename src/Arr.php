<?php

namespace Buildystrap;

use stdClass;

class Arr extends \Illuminate\Support\Arr
{
    public static function from_stdclass(stdClass $stdclass): array
    {
        $array = (array) $stdclass;

        foreach ((array) $stdclass as $key => $item) {
            if ($item instanceof stdClass) {
                $array[$key] = static::from_stdclass($item);
            }
        }

        return $array;
    }
}
