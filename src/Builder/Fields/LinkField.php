<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class LinkField extends Field
{
  protected static function blueprint(): array
  {
    return [
      'config' => [
        'display' => 'Link Field',
      ],
    ];
  }

  public function __toString(): string
  {
    return $this->value();
  }

  public function augment(): void
  {
    parent::augment();
    $this->value = apply_shortcodes($this->value);
  }
}
