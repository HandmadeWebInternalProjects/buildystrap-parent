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
      $this->value = collect((array) $this->raw);
    }
}
