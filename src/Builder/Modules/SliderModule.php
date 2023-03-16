<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class SliderModule extends Module
{
    protected static function blueprint(): array
    {
        return [
      'icon' => 'fa-solid fa-photo-film',
      'fields' => [
        'slides' => [
          'type' => 'replicator-field',
          'fields' => [
            'title' => [
              'type' => 'text-field',
              'config' => [
                'input_type' => 'text',
                'label' => 'Title',
              ],
            ],
            'image' => [
              'type' => 'media-field',
              'config' => [
                'label' => 'Image',
                'multiple' => false,
              ],
            ],
            'show_button' => [
              'type' => 'toggle-field',
              'config' => [
                'label' => 'Show Button',
              ],
            ],
            'cta' => [
              'type' => 'button-field',
              'config' => [
                'label' => 'Call to action',
                'if' => [
                  'show_button' => 'equals true',
                ],
              ],
            ],
          ],
          'config' => [
            'preview' => 'title',
          ],
        ],
      ],
      'config' => [
        'handle' => 'Slider',
        'selectorTab' => 'regular'
      ],
    ];
    }
}
