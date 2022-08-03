<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;

class ButtonField extends Field
{
    protected string $title_class = '';

    protected static function blueprint(): array
    {
        return [
            'config' => [],
        ];
    }

    public function augment(): void
    {
        $this->value = collect((array) $this->raw);
    }

    public function __toString(): string
    {
        $text = $this->value()->get('text', '');
        $url = $this->value()->get('url', '');
        $class = collect([])
          ->push($this?->button_class ?? '')
          ->push($this->value()->get('style', 'btn-primary'))
          ->push($this->value()->get('size', ''))
          ->filter()
          ->implode(' ');

        return sprintf('<a href="%s" class="btn %s">%s</a>', $url, $class, __($text, 'buildystrap'));
    }
}
