<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Builder\Interfaces\LayoutInterface;

abstract class Layout implements LayoutInterface
{
    protected string $uuid;
    protected bool $enabled;
    protected string $type;

    public function __construct($instance)
    {
        $this->uuid = $instance->uuid;
        $this->enabled = $instance->enabled ?? false;
        $this->type = $instance->type;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
