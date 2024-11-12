<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class CheckboxesField extends Field
{
  protected static function blueprint(): array
  {
    return [];
  }

  public function __toString(): string
  {
    return $this->value() ?? '';
  }
}
