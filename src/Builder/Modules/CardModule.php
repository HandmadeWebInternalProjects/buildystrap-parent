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
                    'type' => 'text-field',
                    'config' => [
                        'label' => 'Title',
                    ],
                ],
                'image' => [
                    'type' => 'media-field',
                ],
                'link' => [
                    'type' => 'text-field',
                ],
                'accordion' => [
                    'type' => 'accordion-field',
                    'config' => [
                        'label' => 'Accordion',
                        'multiple' => true,
                    ],
                ],
                'profile-pic' => [
                    'type' => 'media-field',
                    'config' => [
                      'multiple' => true
                    ]
                ],
                'body' => [
                    'type' => 'richtext-field',
                    'config' => [
                        'label' => 'Body',
                        'tinymce' => [
                          'toolbar1' => 'bold,italic,underline',
                          'toolbar2' => false,
                          'height' => '50',
                          'resize' => false,
                          'wpOptions' => [
                            'mediaButtons' => false
                          ]
                        ]
                    ],
                ],
            ],
        ];
    }

    protected function augment(): void
    {
    }
}
