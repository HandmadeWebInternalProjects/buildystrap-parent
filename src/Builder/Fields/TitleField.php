<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;

class TitleField extends Field
{
    protected string $title_class = '';

    protected static function blueprint(): array
    {
        return [
            'config' => [
                'label' => 'Title',
                'hide_label' => true,
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

    public function titleClass(string $class): static
    {
        $this->title_class = $class;
        return $this;
    }

    public function __toString(): string
    {
        $level = $this->value()->get('level', 'h3');
        $text = $this->value()->get('text', '');
        $class = collect([])
          ->push($this->value()->get('class', ''))
          ->push($this->title_class)
          ->push($this->value()->get('color', ''))
          ->push($this->value()->get('size', ''))
          ->filter()
          ->implode(' ');

        return sprintf('<%s class="%s">%s</%s>', $level, $class, $text, $level);
    }
}
