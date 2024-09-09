<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class GroupField extends Field
{
  protected static function blueprint(): array
  {
    return [
      'config' => [
        'display' => 'Group Field',
      ],
    ];
  }
}
