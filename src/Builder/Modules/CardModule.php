<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class CardModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-anchor',
            'fields' => [
                'title' => [
                    'type' => 'title-field',
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
                        'placeholder' => 'Default',
                        'options' => [
                            'Top' => 'flex-column',
                            'Bottom' => 'flex-column-reverse',
                            'Left' => 'flex-row',
                            'Right' => 'flex-row-reverse',
                        ],
                    ],
                ],
                'body' => [
                    'type' => 'richtext-field',
                    'config' => [
                        'label' => 'Body',
                    ],
                ],
                'link' => [
                    'type' => 'link-field',
                    'config' => [
                        'label' => 'Link',
                        'placeholder' => 'https://',
                    ],
                ],
            ]
        ];
    }
}
