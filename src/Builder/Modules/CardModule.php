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
                      'size' => 'full'
                    ]
                ],
                'link' => [
                    'type' => 'relational-field',
                    'config' => [
                        'post_type' => 'posts',
                        'multiple' => true,
                        'if' => [
                            'title' => 'not empty',
                        ],
                    ],
                ],
                'accordion' => [
                    'type' => 'accordion-field',
                    'config' => [
                        'label' => 'Accordion',
                        'multiple' => true,
                        'tinymce' => [
                            'toolbar1' => 'bold,italic,underline',
                            'toolbar2' => false,
                            'height' => '100',
                            'resize' => false,
                            'menubar' => false,
                        ],
                    ],
                ],
                'profile-pic' => [
                    'type' => 'media-field',
                    'config' => [
                        'multiple' => true,
                        'size' => 'full'
                    ],
                ],
                'body' => [
                    'type' => 'richtext-field',
                    'config' => [
                        'label' => 'Body',
                    ],
                ],

            ],
        ];
    }
}
