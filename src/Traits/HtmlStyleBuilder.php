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

    public function inlineStyles(string $inlineStyles = ''): string
    {
        return $this->getInlineStyles($inlineStyles)->implode(' ');
    }

    public function getInlineStyles(string $inlineStyles = ''): Collection
    {
        return collect($this->inline_styles)
            ->push($inlineStyles)
            ->filter();
        //->map(fn ($style) => Str::lower($style));
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


        foreach ($this->getInlineAttribute('display.justify-content', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "justify-content-{$value}",
                default => "justify-content-{$breakpoint}-{$value}"
            };
        }


        foreach ($this->getInlineAttribute('display.align-items', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "align-items-{$value}",
                default => "align-items-{$breakpoint}-{$value}"
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

        /** Background Image URL */
        foreach ($this->getInlineAttribute('background.image.id', []) as $breakpoint => $value) {
            $imageUrl = collect($value)
                ->take(1)
                ->map(fn ($image) => wp_get_attachment_url($image->id))
                ->first();

            if ( ! empty($imageUrl)) {
                $this->inline_styles[] = match ($breakpoint) {
                    'xs' => "--bg-image-url: url('{$imageUrl}');",
                    default => "--bg-image-url-{$breakpoint}: url('{$imageUrl}');"
                };
            }
        }

        /** Background Image Size */
        foreach ($this->getInlineAttribute('background.image.size', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "bg-{$value}",
                default => "bg-{$breakpoint}-{$value}"
            };
        }

        /** Background Image Position */
        foreach ($this->getInlineAttribute('background.image.position', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "bg-{$value}",
                default => "bg-{$breakpoint}-{$value}"
            };
        }

        /** Background Image Repeat */
        foreach ($this->getInlineAttribute('background.image.repeat', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "bg-{$value}",
                default => "bg-{$breakpoint}-{$value}"
            };
        }

        /** Background Color */
        foreach ($this->getInlineAttribute('background.color', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "bg-{$value}",
                default => "bg-{$breakpoint}-{$value}"
            };
        }

        /** Typography Color */
        foreach ($this->getInlineAttribute('typography.color', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "text-{$value}",
                default => "text-{$breakpoint}-{$value}"
            };
        }

        /** Typography Font Family */
        foreach ($this->getInlineAttribute('typography.font-family', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "font-family-{$value}",
                default => "font-family-{$breakpoint}-{$value}"
            };
        }

        /** Typography Font Weight */
        foreach ($this->getInlineAttribute('typography.font-weight', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "font-{$value}",
                default => "font-{$breakpoint}-{$value}"
            };
        }

        /** Typography Font Size */
        foreach ($this->getInlineAttribute('typography.font-size', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "fs-{$value}",
                default => "fs-{$breakpoint}-{$value}"
            };
        }

        /** Typography Text Align */
        foreach ($this->getInlineAttribute('typography.text-align', []) as $breakpoint => $value) {
            $this->html_classes[] = match ($breakpoint) {
                'xs' => "text-{$value}",
                default => "text-{$breakpoint}-{$value}"
            };
        }
    }
}
