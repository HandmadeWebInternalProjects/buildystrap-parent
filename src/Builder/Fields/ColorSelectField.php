<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class ColorSelectField extends Field
{
    protected static function blueprint(): array
    {
        return [];
    }

    public function __toString(): string
    {
        if ($this->value() === null || $this->value() === '') {
            return '';
        }
        return $this->value();
    }
}
