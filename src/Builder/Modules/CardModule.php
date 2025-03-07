<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class CardModule extends Module
{
  protected static function blueprint(): array
  {
    return [
      'icon' => 'fa-regular fa-address-card',
      'fields' => [
        'title' => [
          'type' => 'title-field',
        ],
        'title_spacing' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Title Spacing',
            'instructions' => 'Change the spacing between the title and body. Enter any valid value e.g 10px, 1em, 1rem, 1vh, 1vw',
          ],
        ],
        'image' => [
          'type' => 'media-field',
          'config' => [
            'label' => 'Image',
            'size' => 'full',
          ],
        ],
        'image_placement' => [
          'type' => 'select-field',
          'config' => [
            'label' => 'Image Placement',
            'class' => 'g-col-6',
            'placeholder' => 'Default',
            'options' => [
              'Top' => 'flex-column',
              'Bottom' => 'flex-column-reverse',
              'Left' => 'flex-row',
              'Right' => 'flex-row-reverse',
            ],
            'default' => 'flex-column',
          ],
        ],
        'image_aspect_ratio' => [
          'type' => 'select-field',
          'config' => [
            'label' => 'Image Aspect Ratio',
            'class' => 'g-col-6',
            'placeholder' => 'Default',
            'options' => [
              '1/1',
              '4/3',
              '16/9',
              '16/10'
            ],
            'taggable' => true,
          ],
        ],
        'body' => [
          'type' => 'richtext-field',
          'config' => [
            'label' => 'Body',
          ],
        ],
        'button_groups' => [
          'type' => 'replicator-field',
          'config' => [
            'label' => 'Button',

          ],
          'fields' => [
            'button' => [
              'type' => 'button-field',
              'config' => [
                'label' => false,
              ],
            ],
          ]
        ],
        'button_group_class' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Button Group Class',
            'class' => 'g-col-12',
          ],
        ],
        'button_group_alignment' => [
          'type' => 'select-field',
          'config' => [
            'label' => 'Button Group Alignment',
            'class' => 'g-col-12',
            'options' => [
              'Start' => 'start',
              'Center' => 'center',
              'End' => 'end',
            ],
            'responsive' => true,
          ],
        ],
      ],
      'config' => [
        'selectorTab' => 'regular'
      ]
    ];
  }
}
