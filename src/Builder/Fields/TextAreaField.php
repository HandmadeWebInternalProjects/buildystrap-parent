<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class TextAreaField extends Field
{
  protected static function blueprint(): array
  {
    return [
      'config' => [
        'display' => 'Textarea Field',
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
    if (is_string($this->value)) {
      $this->value = apply_shortcodes($this->value);
    }
  }
}
