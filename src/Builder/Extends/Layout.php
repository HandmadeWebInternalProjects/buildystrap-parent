<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Arr;
use Buildystrap\Str;
use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Augment;
use Buildystrap\Traits\Config;
use Buildystrap\Traits\InlineAttributes;
use stdClass;

use function collect;
use function implode;

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
        $generatedClasses = [];

        foreach ($this->getInlineAttribute('display.position', []) as $breakpoint => $value) {
            $generatedClasses[] = Str::format('position-%s-%s', $breakpoint, $value);
        }

        foreach ($this->getInlineAttribute('display.attributes', []) as $position => $items) {
            foreach ($items as $breakpoint => $value) {
                $generatedClasses[] = Str::format('%s-%s-%s', $position, $breakpoint, $value);
            }
        }

        foreach ($this->getInlineAttribute('display.property', []) as $breakpoint => $value) {
            $generatedClasses[] = Str::format('property-%s-%s', $breakpoint, $value);
        }

        foreach ($this->getInlineAttribute('display.column-gap', []) as $breakpoint => $value) {
            $generatedClasses[] = Str::format('colgap-%s-%s', $breakpoint, $value);
        }

        foreach ($this->getInlineAttribute('display.row-gap', []) as $breakpoint => $value) {
            $generatedClasses[] = Str::format('rowgap-%s-%s', $breakpoint, $value);
        }

        foreach ($this->getInlineAttribute('display.order', []) as $breakpoint => $value) {
            $generatedClasses[] = Str::format('order-%s-%s', $breakpoint, $value);
        }

        foreach ($this->getInlineAttribute('margin', []) as $position => $items) {
            foreach ($items as $breakpoint => $value) {
                $pos = match ($position) {
                    'top' => 'mt',
                    'bottom' => 'mb',
                    'left' => 'ms',
                    'right' => 'me'
                };

                $generatedClasses[] = Str::format('%s-%s-%s', $pos, $breakpoint, $value);
            }
        }

        foreach ($this->getInlineAttribute('padding', []) as $position => $items) {
            foreach ($items as $breakpoint => $value) {
                $pos = match ($position) {
                    'top' => 'pt',
                    'bottom' => 'pb',
                    'left' => 'ps',
                    'right' => 'pe'
                };

                $generatedClasses[] = Str::format('%s-%s-%s', $pos, $breakpoint, $value);
            }
        }

        $classes = collect([
            'buildystrap-' . $this->type(),
            implode(' ', $generatedClasses),
            $this->getAttribute('class', ''),
            $classes,
        ])->filter()->implode(' ');

        return Str::lower($classes);
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
