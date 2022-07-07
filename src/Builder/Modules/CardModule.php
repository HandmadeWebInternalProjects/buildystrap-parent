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
                    'type' => 'relational-field',
                    'config' => [
                        'post_type' => 'testimonials',
                        'multiple' => true,
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

    protected function augment(): void
    {
    }
}
