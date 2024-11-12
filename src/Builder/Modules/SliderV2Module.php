<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Buildystrap\Traits\RecursiveFieldMap;

class SliderV2Module extends Module
{
  use RecursiveFieldMap;

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

            'body' => [
              'type' => 'richtext-field',
              'config' => [
                'label' => 'Body',
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
        'slider_settings' => [
          'type' => 'group-field',
          'fields' => [
            'slidesPerView' => [
              'type' => 'text-field',
              'config' => [
                'label' => 'Slides Per View',
                'popover' => 'How many slides are visible at the same time, can be a decimal e.g 2.5.',
                'responsive' => true,
              ],
            ],
            'spaceBetween' => [
              'type' => 'text-field',
              'config' => [
                'label' => 'Space Between',
                'popover' => 'The space between slides (in pixels).',
                'responsive' => true,
              ],
            ],
            'additional_settings' => [
              'type' => 'replicator-field',
              'fields' => [
                'name' => [
                  'type' => 'text-field',
                ],
                'value' => [
                  'type' => 'text-field',
                  'config' => [
                    'label' => 'Value',
                    'responsive' => true,
                  ],
                ],
              ],
              'config' => [
                'label' => 'Additional Slider Settings',
                'popover' => 'Add additional settings to the slider. See <a href="https://swiperjs.com/swiper-api" target="_blank">Swiper API</a> for more information.',
                'preview' => 'name',
              ],
            ],
          ],
          'config' => [
            'label' => 'Slider Settings',
          ],
        ]
      ],
      'config' => [
        'handle' => 'Slider',
        'selectorTab' => 'regular',
      ],
    ];
  }
}
