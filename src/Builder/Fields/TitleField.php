<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;
use function sprintf;

class TitleField extends Field
{
    protected string $title_class = '';

    protected static function blueprint(): array
    {
        return [
            'config' => [
                'label' => 'Heading',
            ],
        ];
    }

    public function augment(): void
    {
        $this->value = collect((array) $this->raw);
    }

    public function titleClass(string $class): static
    {
        $this->title_class = $class;
        return $this;
    }

    public function __toString(): string
    {
        $level = $this->value()->get('level');
        $level = !empty($level) ? $level : 'h3';
        $text = $this->value()->get('text', '');
        $size = [];
        $size_vars = [];
        $color = [];
        $weight = [];

        foreach ($this->value()->get('size', []) as $breakpoint => $value) {
            if ($value) {
                $is_taggable = !in_array($value, range(1, 6));
                if (!$is_taggable) {
                    $size[] = match ($breakpoint) {
                        'xs' => "fs-{$value}",
                        default => "fs-{$breakpoint}-{$value}"
                    };
                } else {
                    if (!str_contains($this->title_class, "fs-taggable")) {
                        $this->title_class .= " fs-taggable";
                    }
                    $size_vars[] = match ($breakpoint) {
                        'xs' => "--font-size: {$value};",
                        default => "--font-size-{$breakpoint}: {$value};"
                    };
                }
            }
        }

        foreach ($this->value()->get('color', []) as $breakpoint => $value) {
            if ($value) {
                $color[] = match ($breakpoint) {
                    'xs' => "text-{$value}",
                    default => "text-{$breakpoint}-{$value}"
                };
            }
        }

        foreach ($this->value()->get('weight', []) as $breakpoint => $value) {
            if ($value) {
                $weight[] = match ($breakpoint) {
                    'xs' => "font-{$value}",
                    default => "font-{$breakpoint}-{$value}"
                };
            }
        }

        $class = collect([])
            ->push($this->value()->get('class', ''))
            ->push($this->title_class)
            ->merge($color)
            ->merge($weight)
            ->merge($size)
            ->filter()
            ->implode(' ');

        $style = collect([])
            ->merge($size_vars)
            ->filter()
            ->implode(' ');

        return sprintf('<%s class="%s" style="%s">%s</%s>', $level, $class, $style, $text, $level);
    }
}
