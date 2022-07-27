<?php

namespace Buildystrap;

use function sprintf;

class Str extends \Illuminate\Support\Str
{
    /**
     * Str wrapper for sprintf
     *
     * @param string $format
     * @param mixed ...$values
     * @return string
     */
    public static function format(string $format, mixed ...$values): string
    {
        return sprintf($format, ...$values);
    }
}
