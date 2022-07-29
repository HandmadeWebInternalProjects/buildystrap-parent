<?php

namespace Buildystrap\Traits;

use Buildystrap\Builder\Extends\Module;
use Illuminate\Support\Collection;

use function collect;
use function wp_get_attachment_url;

trait HtmlStyleBuilder
{
    protected array $html_classes = [];
    protected array $inline_styles = [];

    public function classes(string $classes = ''): string
    {
        return $this->getClasses($classes)->implode(' ');
    }

    public function inlineStyles(string $styles = ''): string
    {
        return collect($this->inline_styles)->filter()->implode(' ');
    }

    public function getClasses(string $classes = ''): Collection
    {
        $classes = collect([
            $this instanceof Module ? 'buildystrap-module' : null,
            'buildystrap-' . $this->type(),
            $classes,
        ]);

        return $classes
            ->merge($this->html_classes)
            ->push($this->getAttribute('class', ''))
            ->filter();
        //->map(fn ($class) => Str::lower($class));
    }

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

        /** Background */
        foreach ($this->getInlineAttribute('background', []) as $attr => $items) {
            /** Image */
            if ($attr === 'image') {
                foreach ($items as $item => $values) {
                    /** Image Url */
                    if ($item === 'id') {
                        $images = collect($values)
                            ->map(
                                fn ($images) => collect($images)
                                    ->take(1)
                                    ->map(fn ($image) => wp_get_attachment_url($image->id))
                                    ->first()
                            )->filter();

                        foreach ($images as $breakpoint => $imageUrl) {
                            $this->inline_styles[] = match ($breakpoint) {
                                'xs' => "--bg-image-url: '{$imageUrl}';",
                                default => "--bg-image-url-{$breakpoint}: '{$imageUrl}';"
                            };
                        }
                    } else {
                        /** Image BG Position/Size etc */
                        foreach ($values as $breakpoint => $value) {
                            $this->html_classes[] = match ($breakpoint) {
                                'xs' => "bg-{$value}",
                                default => "bg-{$breakpoint}-{$value}"
                            };
                        }
                    }
                }
            } elseif ($attr === 'color') {
                /** Background */
                foreach ($items as $breakpoint => $value) {
                    $this->html_classes[] = match ($breakpoint) {
                        'xs' => "bg-{$value}",
                        default => "bg-{$breakpoint}-{$value}"
                    };
                }
            }
        }
    }
}
