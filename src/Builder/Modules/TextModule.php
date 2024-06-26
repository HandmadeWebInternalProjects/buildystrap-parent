<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class TextModule extends Module
{
    protected static function blueprint(): array
    {
        return [
          'icon' => 'fa-solid fa-paragraph',
          'fields' => [
            'text' => [
              'config' => [
                'label' => 'Text',
              ],
              'type' => 'richtext-field',
            ],
          ],
          'config' => [
            'selectorTab' => 'regular'
          ]
        ];
    }
}
