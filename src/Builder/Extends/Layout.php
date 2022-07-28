<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Arr;
use Buildystrap\Str;
use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Augment;
use Buildystrap\Traits\Config;
use Buildystrap\Traits\InlineAttributes;
use Illuminate\Support\Collection;
use stdClass;

use function collect;

abstract class Layout
{
    use Attributes;
    use Augment;
    use Config;
    use InlineAttributes;

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

    public function getClasses(string $classes = ''): Collection
    {
        $classes = collect([
            'buildystrap-' . $this->type(),
            $classes,
        ]);

        return $classes
            ->merge($this->html_classes)
            ->push($this->getAttribute('class', ''))
            ->filter();
        //->map(fn ($class) => Str::lower($class));
    }

    public function classes(string $classes = ''): string
    {
        return $this->getClasses($classes)->implode(' ');
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

    protected function generateClasses(): void
    {
        /** Position */
        foreach ($this->getInlineAttribute('display.position', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
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
                    $this->html_classes[] = match ($breakpoint) {
                        'xs' => "{$pos}-{$value}",
                        default => "{$pos}-{$breakpoint}-{$value}"
                    };
                }
            }
        }

        /** Flex/Grid */
        foreach ($this->getInlineAttribute('display.property', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "d-{$value}",
                default => "d-{$breakpoint}-{$value}"
            };
        }

        /** Col Gap */
        foreach ($this->getInlineAttribute('display.column-gap', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "colgap-{$value}",
                default => "colgap-{$breakpoint}-{$value}"
            };
        }

        /** Row Gap */
        foreach ($this->getInlineAttribute('display.row-gap', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "rowgap-{$value}",
                default => "rowgap-{$breakpoint}-{$value}"
            };
        }

        /** Order */
        foreach ($this->getInlineAttribute('display.order', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "order-{$value}",
                default => "order-{$breakpoint}-{$value}"
            };
        }

        /** Min Width */
        foreach ($this->getInlineAttribute('minWidth', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "min-w-{$value}",
                default => "min-w-{$breakpoint}-{$value}"
            };
        }

        /** Width */
        foreach ($this->getInlineAttribute('width', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "w-{$value}",
                default => "w-{$breakpoint}-{$value}"
            };
        }

        /** Max Width */
        foreach ($this->getInlineAttribute('maxWidth', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "max-w-{$value}",
                default => "max-w-{$breakpoint}-{$value}"
            };
        }

        /** Min Height */
        foreach ($this->getInlineAttribute('minHeight', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "min-h-{$value}",
                default => "min-h-{$breakpoint}-{$value}"
            };
        }

        /** Height */
        foreach ($this->getInlineAttribute('height', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "h-{$value}",
                default => "h-{$breakpoint}-{$value}"
            };
        }

        /** Max Height */
        foreach ($this->getInlineAttribute('maxHeight', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
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
                    $this->html_classes[] = match ($breakpoint) {
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
                    $this->html_classes[] = match ($breakpoint) {
                        'xs' => "{$pos}-{$value}",
                        default => "{$pos}-{$breakpoint}-{$value}"
                    };
                }
            }
        }
    }
}
