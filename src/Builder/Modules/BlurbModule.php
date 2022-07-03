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
                'another' => [
                    'type' => 'media-field',
                    'config' => [
                      'multiple' => true
                    ]
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
