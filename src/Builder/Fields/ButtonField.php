<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;
use function sprintf;

class ButtonField extends Field
{
    protected string $title_class = '';
    protected string $button_class = '';

    protected static function blueprint(): array
    {
        return [
          'config' => [
            'sizes' => [
              'Small' => 'btn-sm',
              'Large' => 'btn-lg',
            ],
            'types' => [
              'Primary' => 'btn-primary',
              'Secondary' => 'btn-secondary',
              'Tertiary' => 'btn-tertiary',
              'Warning' => 'btn-warning',
              'Danger' => 'btn-danger',
              'Success' => 'btn-success',
              'Info' => 'btn-info',
              'Unstyled' => 'btn-unstyled',
              'Link' => 'btn-link',
            ]
          ],
        ];
    }

    public function augment(): void
    {
        $this->value = collect((array) $this->raw);
    }

    public function __toString(): string
    {
        $text = $this->value()->get('text', '') ?? '';
        $bg_colour = $this->value()->get('style') ? "btn-{$this->value()->get('style')}" : '';
        $type = $this->value()->get('type', 'btn-primary') ? "{$this->value()->get('type', 'btn-primary')}" : 'btn-primary';
        $size = $this->value()->get('size', null) ?? null;
        $color = $this->value()->get('color', null) ? "text-{$this->value()->get('color', null)}" : null;
        $target = ($this->value()->get('target') ?? null) && $this->value()->get('target') ? '_blank' : '_self';
        $class = collect([])
          ->push('btn')
          ->push($bg_colour)
          ->push($type)
          ->push($size)
          ->push($color)
          ->filter()
          ->implode(' ');
        $url = $this->value()->get('url', []) ?? [];

        return sprintf('<a href="%s" target="%s" class="%s">%s</a>', $url['url'] ?? '#', $target, $class, __($text, 'buildystrap'));
    }
}
