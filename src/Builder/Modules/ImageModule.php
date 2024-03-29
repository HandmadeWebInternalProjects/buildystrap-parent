<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class ImageModule extends Module
{
    protected static function blueprint(): array
    {
        return [
          'icon' => 'fa-solid fa-image',
          'fields' => [
            'image' => [
              'type' => 'image-field',
              'config' => [
                'label' => false
              ],
            ],
            'enable_lightbox' => [
              'type' => 'toggle-field',
              'config' => [
                'label' => 'Enable Lightbox',
                'class' => 'g-col-12',
              ],
            ],
        'link' => [
          'type' => 'link-field',
          'config' => [
            'label' => 'Link',
            'class' => 'g-col-12',
          ],
        ],
          ],
          'config' => [
            'selectorTab' => 'regular'
          ]
        ];
    }

    // public function augment(): void
    // {
  //     // Remember for modules to run
  //     parent::augment();
    // }
}
