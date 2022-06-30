<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Config;

abstract class Layout
{
    use Attributes;
    use Config;

    protected string $uuid;
    protected string $type;

    public function __construct($instance)
    {
        $this->uuid = $instance->uuid;
        $this->type = $instance->type;

        $this->config = [];
        if (isset($instance->config) && is_iterable($instance->config)) {
            $this->config = (array) $instance->config;
        }
    }

    public function enabled(): bool
    {
        return $this->getFromConfig('enabled', false);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    abstract public function render(): string;
}
