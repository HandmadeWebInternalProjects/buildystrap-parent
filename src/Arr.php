<?php

namespace Buildystrap;

use stdClass;

class Arr extends \Illuminate\Support\Arr
{
    public static function from_stdclass(stdClass $stdclass): array
    {
        $array = [];

        foreach ((array) $stdclass as $key => $item) {
            if ($item instanceof stdClass) {
                $array[$key] = static::from_stdclass($item);
            } else {
                $array[$key] = $item;
            }
        }

        return $array;
    }
}
