<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Arr;
use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Augment;
use Buildystrap\Traits\Config;
use Buildystrap\Traits\HtmlStyleBuilder;
use Buildystrap\Traits\InlineAttributes;
use stdClass;

abstract class Layout
{
    use Attributes;
    use Augment;
    use Config;
    use InlineAttributes;
    use HtmlStyleBuilder;

    protected string $uuid;
    protected string $type;
    protected ?Layout $parent;

    public function __construct($instance, ?Layout $parent = null)
    {
        $this->parent = $parent;
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

    public function type(): string
    {
        return $this->type;
    }

    public function augment(): void
    {
        $this->generateClasses();
    }

    public function enabled(): bool
    {
        return $this->getFromConfig('enabled', false);
    }

    public function hasParent(): bool
    {
        return $this->parent instanceof Layout;
    }

    public function parent(): ?Layout
    {
        return $this->parent;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->augmented()->render();
    }

    abstract public function render(): string;
}
