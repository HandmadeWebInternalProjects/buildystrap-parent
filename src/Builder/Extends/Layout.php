<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Traits\Config;

abstract class Layout
{
    use Config;

    protected string $uuid;
    protected string $type;

    abstract public function render(): string;

    public function __construct($instance)
    {
        $this->uuid = $instance->uuid;
        $this->type = $instance->type;

        $this->config = (array) $instance->config ?? [];
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function enabled(): bool
    {
        return $this->getFromConfig('enabled', false);
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
