<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

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

    public function __toString(): string
    {
        $level = $this->get('level', 'h3');
        $text = $this->get('text', '');
        $size = $this->get('size', '');
        $colour = $this->get('color', '');
        $class = $this->get('class', '');

        return sprintf('<%s class="%s %s %s">%s</%s>', $level, $class, $size, $colour, $text, $level);
    }

    public function augment(): void
    {
    }
}
