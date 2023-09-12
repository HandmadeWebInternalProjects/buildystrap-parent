<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class GalleryModule extends Module
{
    protected static function blueprint(): array
    {
        return [
          'icon' => 'fa-solid fa-images',
          'fields' => [
            'images' => [
              'type' => 'media-field',
              'config' => [
                'label' => 'Images',
            'multiple' => "toggle",
              ],
            ],
            'image_size' => [
              'type' => 'select-field',
              'config' => [
                'label' => 'Source Image Size',
                'class' => 'g-col-6',
                'options' => collect(get_registered_image_sizes())->map(
                    fn ($size, $key) => strtolower($key)
                )->toArray(),
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
            'columns' => [
              'type' => 'select-field',
              'config' => [
                'label' => 'Columns',
                'class' => 'g-col-4',
                'options' => [
                  '1',
                  '2',
                  '3',
                  '4',
                  '5',
                  '6',
                ],
                'responsive' => true,
              ],
            ],
            'col_gap' => [
              'type' => 'select-field',
              'config' => [
                'label' => 'Column Gap',
                'class' => 'g-col-4',
                'options' => [
                  '0',
                  '1',
                  '2',
                  '3',
                  '4',
                  '5',
                  '6',
                ],
                'responsive' => true,
              ],
            ],
            'place_items' => [
              'type' => 'select-field',
              'config' => [
                'label' => 'Place Items',
                'class' => 'g-col-4',
                'options' => [
                  'center',
                  'start',
                  'end',
                ],
                'responsive' => true,
              ],
            ],
            'enable_lightbox' => [
              'type' => 'toggle-field',
              'config' => [
                'label' => 'Enable Lightbox',
                'class' => 'g-col-6',
              ],
            ],
            'fit_to_column' => [
              'type' => 'toggle-field',
              'config' => [
                'label' => 'Fit images to column',
                'class' => 'g-col-6',
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
