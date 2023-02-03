<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class TabModule extends Module
{
  protected static function blueprint(): array
  {
    return [
      'icon' => 'fa-solid fa-equals',
      'fields' => [
        'tabs' => [
          'type' => 'replicator-field',
          'config' => [
            'label' => 'Tab',
            'preview' => 'title',
          ],
          'fields' => [
            'title' => [
              'type' => 'text-field',
              'config' => [
                'label' => 'Title',
              ],
            ],
            'content' => [
              'type' => 'richtext-field',
              'config' => [
                'label' => 'Content',
              ],
            ],
          ]
        ],
      ],
      'config' => [
        'selectorTab' => 'regular'
      ]
    ];
  }
}
