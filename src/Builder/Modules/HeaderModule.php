<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class HeaderModule extends Module
{
  protected static function blueprint(): array
  {
    return [
      'icon' => 'fa-solid fa-heading',
      'fields' => [
        'title' => [
          'type' => 'title-field',
        ],
      ],
      'config' => [
        'selectorTab' => 'regular'
      ]
    ];
  }
}
