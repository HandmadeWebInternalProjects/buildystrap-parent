<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;

class TitleField extends Field
{
    protected static function blueprint(): array
    {
        return [
            'config' => [
                'label' => 'Title',
                'tinymce' => [
                    'toolbar1' => 'bold,italic,underline',
                    'toolbar2' => false,
                    'height' => '20',
                    'autoresize_min_height' => '20',
                    'resize' => false,
                    'menubar' => false,
                    'statusbar' => false,
                ],
            ],
        ];
    }

    public function augment(): void
    {
        $this->value = collect((array) $this->raw);
    }

    public function __toString(): string
    {
        $level = $this->value()->get('level', 'h3');
        $text = $this->value()->get('text', '');
        $size = $this->value()->get('size', '');
        $colour = $this->value()->get('color', '');
        $class = $this->value()->get('class', '');

        return sprintf('<%s class="%s %s %s">%s</%s>', $level, $class, $size, $colour, $text, $level);
    }
}
