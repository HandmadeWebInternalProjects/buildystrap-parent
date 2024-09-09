<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Buildystrap\Traits\RecursiveFieldMap;

class AccordionModule extends Module
{
  use RecursiveFieldMap;

  protected static function blueprint(): array
  {
    return [
      'icon' => 'fa-solid fa-chevron-down',
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
            'open' => [
              'type' => 'toggle-field',
              'config' => [
                'label' => 'Open by default',
              ],
            ],
            'cta' => [
              'type' => 'button-field',
              'config' => [
                'label' => 'CTA',
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
