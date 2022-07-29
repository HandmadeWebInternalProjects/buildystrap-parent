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
                'columns' => [
                    'type' => 'select-field',
                    'config' => [
                        'label' => 'Columns',
                        'options' => [
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                        ],
                    ],
                ],
                'col_gap' => [
                    'type' => 'select-field',
                    'config' => [
                        'label' => 'Column Gap',
                        'options' => [
                            '0' => '0',
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
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
