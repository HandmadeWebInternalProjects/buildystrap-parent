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

        /** Position */
        foreach ($this->getInlineAttribute('display.position', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "position-{$value}",
                default => "position-{$breakpoint}-{$value}"
            };
        }

        /** Position location (top/bottom etc) */
        foreach ($this->getInlineAttribute('display.attributes', []) as $position => $items) {
            foreach ($items as $breakpoint => $value) {
                $pos = match ($position) {
                    'top' => 'top',
                    'bottom' => 'bottom',
                    'left' => 'start',
                    'right' => 'end',
                    default => ''
                };

                if ( ! empty($pos)) {
                    $generatedClasses[] = match ($breakpoint) {
                        'xs' => "{$pos}-{$value}",
                        default => "{$pos}-{$breakpoint}-{$value}"
                    };
                }
            }
        }

        /** Flex/Grid */
        foreach ($this->getInlineAttribute('display.property', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "d-{$value}",
                default => "d-{$breakpoint}-{$value}"
            };
        }

        /** Col Gap */
        foreach ($this->getInlineAttribute('display.column-gap', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "colgap-{$value}",
                default => "colgap-{$breakpoint}-{$value}"
            };
        }

        /** Row Gap */
        foreach ($this->getInlineAttribute('display.row-gap', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "rowgap-{$value}",
                default => "rowgap-{$breakpoint}-{$value}"
            };
        }

        /** Order */
        foreach ($this->getInlineAttribute('display.order', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "order-{$value}",
                default => "order-{$breakpoint}-{$value}"
            };
        }

        /** Min Width */
        foreach ($this->getInlineAttribute('minWidth', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "min-w-{$value}",
                default => "min-w-{$breakpoint}-{$value}"
            };
        }

        /** Width */
        foreach ($this->getInlineAttribute('width', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "w-{$value}",
                default => "w-{$breakpoint}-{$value}"
            };
        }

        /** Max Width */
        foreach ($this->getInlineAttribute('maxWidth', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "max-w-{$value}",
                default => "max-w-{$breakpoint}-{$value}"
            };
        }

        /** Min Height */
        foreach ($this->getInlineAttribute('minHeight', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "min-h-{$value}",
                default => "min-h-{$breakpoint}-{$value}"
            };
        }

        /** Height */
        foreach ($this->getInlineAttribute('height', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "h-{$value}",
                default => "h-{$breakpoint}-{$value}"
            };
        }

        /** Max Height */
        foreach ($this->getInlineAttribute('maxHeight', []) as $breakpoint => $value) {
            $generatedClasses[] = match ($breakpoint) {
                'xs' => "max-h-{$value}",
                default => "max-h-{$breakpoint}-{$value}"
            };
        }

        /** Margin */
        foreach ($this->getInlineAttribute('margin', []) as $position => $items) {
            foreach ($items as $breakpoint => $value) {
                $pos = match ($position) {
                    'top' => 'mt',
                    'bottom' => 'mb',
                    'left' => 'ms',
                    'right' => 'me',
                    default => ''
                };

                if ( ! empty($pos)) {
                    $generatedClasses[] = match ($breakpoint) {
                        'xs' => "{$pos}-{$value}",
                        default => "{$pos}-{$breakpoint}-{$value}"
                    };
                }
            }
        }

        /** Padding */
        foreach ($this->getInlineAttribute('padding', []) as $position => $items) {
            foreach ($items as $breakpoint => $value) {
                $pos = match ($position) {
                    'top' => 'pt',
                    'bottom' => 'pb',
                    'left' => 'ps',
                    'right' => 'pe',
                    default => ''
                };

                if ( ! empty($pos)) {
                    $generatedClasses[] = match ($breakpoint) {
                        'xs' => "{$pos}-{$value}",
                        default => "{$pos}-{$breakpoint}-{$value}"
                    };
                }
            }
        }

        $classes = collect([
            'buildystrap-' . $this->type(),
            $classes,
            implode(' ', $generatedClasses),
            $this->getAttribute('class', ''),
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
