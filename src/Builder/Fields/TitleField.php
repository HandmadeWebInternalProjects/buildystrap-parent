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
                'tinymce' => [
                    'toolbar1' => 'bold,italic,underline,styleselect',
                    'toolbar2' => false,
                    'height' => '20',
                    'autoresize_min_height' => '20',
                    'resize' => false,
                    'menubar' => false,
                    'statusbar' => false,
                    'forced_root_block' => false,
                ],
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
        $level = ! empty($level) ? $level : 'h3';
        $text = $this->value()->get('text', '');
        $size = [];
        $color = [];
        $weight = [];

        foreach ($this->value()->get('size', []) as $breakpoint => $value) {
            $size[] = match ($breakpoint) {
                'xs' => "fs-{$value}",
                default => "fs-{$breakpoint}-{$value}"
            };
        }

        foreach ($this->value()->get('color', []) as $breakpoint => $value) {
            $color[] = match ($breakpoint) {
                'xs' => "text-{$value}",
                default => "text-{$breakpoint}-{$value}"
            };
        }

        foreach ($this->value()->get('weight', []) as $breakpoint => $value) {
            $weight[] = match ($breakpoint) {
                'xs' => "font-{$value}",
                default => "font-{$breakpoint}-{$value}"
            };
        }

        $class = collect([])
            ->push($this->value()->get('class', ''))
            ->push($this->title_class)
            ->merge($color)
            ->merge($weight)
            ->merge($size)
            ->filter()
            ->implode(' ');

        return sprintf('<%s class="%s">%s</%s>', $level, $class, $text, $level);
    }
}
