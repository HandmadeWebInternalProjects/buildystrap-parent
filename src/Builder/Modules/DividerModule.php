<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class DividerModule extends Module
{
    protected static function blueprint(): array
    {
        return [
          'icon' => 'fa-solid fa-minus',
          'fields' => [
            'height' => [
              'config' => [
                'label' => 'Height',
              ],
              'type' => 'text-field',
            ],
          ],
          'config' => [
            'selectorTab' => 'regular'
          ]
        ];
    }
}
