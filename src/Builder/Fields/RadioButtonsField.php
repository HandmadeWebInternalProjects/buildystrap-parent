<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class RadioButtonsField extends Field
{
  protected static function blueprint(): array
  {
    return [];
  }

    public function __toString(): string
    {
        if($this->value() === null || $this->value() === '') {
            return '';
        }
        return $this->value();
    }
}
