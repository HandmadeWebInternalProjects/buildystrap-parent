<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Arr;
use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Augment;
use Buildystrap\Traits\Config;
use Buildystrap\Traits\InlineAttributes;
use stdClass;

abstract class Layout
{
    use Attributes;
    use Augment;
    use Config;
    use InlineAttributes;

    protected string $uuid;
    protected string $type;

    public function __construct($instance)
    {
        $this->uuid = $instance->uuid;
        $this->type = $instance->type;

        if (isset($instance->config) && $instance->config instanceof stdClass) {
            $this->config = Arr::from_stdclass($instance->config);
        }

        if (isset($instance->attributes) && $instance->attributes instanceof stdClass) {
            $this->attributes = Arr::from_stdclass($instance->attributes);
        }

        if (isset($instance->inline) && $instance->inline instanceof stdClass) {
            $this->inline_attributes = Arr::from_stdclass($instance->inline);
        }
    }

    public function classes(string $classes = ''): string
    {
        return collect([
            'buildystrap-' . $this->type(),
            $this->getAttribute('class', ''),
            $classes,
        ])->filter()->implode(' ');
    }

    public function type(): string
    {
        return $this->type;
    }

    public function enabled(): bool
    {
        return $this->getFromConfig('enabled', false);
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
