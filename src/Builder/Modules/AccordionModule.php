<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class AccordionModule extends Module
{
  protected static function blueprint(): array
  {
    return [
      'icon' => 'fa-solid fa-equals',
      'fields' => [
        'accordion' => [
          'type' => 'replicator-field',
          'config' => [
            'label' => 'Accordion',
            'preview' => 'title'
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
