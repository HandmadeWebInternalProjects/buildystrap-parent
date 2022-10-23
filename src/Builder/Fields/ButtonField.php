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
      'config' => [],
    ];
    }

    public function augment(): void
    {
        $this->value = collect((array) $this->raw);
    }

  public function __toString(): string
  {
    $text = $this->value()->get('text', '') ?? '';
    $bg_colour = $this->value()->get('style', 'btn-primary') ? "btn-{$this->value()->get('style', 'btn-primary')}" : 'btn-primary';
    $size = $this->value()->get('size', null) ?? null;
    $color = $this->value()->get('color', null) ? "text-{$this->value()->get('color', null)}" : null;
    $target = ($this->value()->get('target') ?? null) && $this->value()->get('target') ? '_blank' : '_self';
    $class = collect([])
      ->push('btn')
      ->push($bg_colour)
      ->push($size)
      ->push($color)
      ->filter()
      ->implode(' ');
        $url = $this->value()->get('url', []) ?? [];

        return sprintf('<a href="%s" target="%s" class="%s">%s</a>', $url['url'] ?? '#', $target, $class, __($text, 'buildystrap'));
    }
}
