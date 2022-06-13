<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Builder\Interfaces\LayoutInterface;

abstract class Layout implements LayoutInterface
{
    protected bool $enabled;

    public function __construct($instance)
    {
        $this->enabled = $instance->enabled ?? false;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
