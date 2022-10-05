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
                        'multiple' => true,
                    ],
                ],
                'image_size' => [
                    'type' => 'select-field',
                    'config' => [
                        'label' => 'Image Size',
                        'options' => collect(get_registered_image_sizes())->map(
                            fn ($size, $key) => strtolower($key)
                        )->toArray(),
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
            ],
        ];
    }

    // public function augment(): void
    // {
    //     // Remember for modules to run
    //     parent::augment();
    // }
}
