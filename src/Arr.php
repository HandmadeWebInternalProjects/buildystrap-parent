<?php

namespace Buildystrap;

use stdClass;

class Arr extends \Illuminate\Support\Arr
{
    /**
     * Recursively convert stdClass into an array
     *
     * @param stdClass $stdclass
     * @return array
     */
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
