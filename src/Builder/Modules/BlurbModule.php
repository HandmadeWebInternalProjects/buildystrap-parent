<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class BlurbModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-anchor',
            'fields' => [
                'title' => [
                    'type' => 'text-field',
                    'config' => [
                        'label' => 'Blurb Text',
                    ],
                ],
                'url' => [
                    'type' => 'text-field',
                ],
                'testimonials' => [
                    'type' => 'relational-field',
                    'config' => [
                      'post_type' => 'testimonials',
                      'multiple' => true
                    ]
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
                'content' => [
                    'type' => 'richtext-field',
                ],
            ],
        ];
    }

    protected function augment(): void
    {
    }
}
