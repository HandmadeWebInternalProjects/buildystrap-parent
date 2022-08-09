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
                        'size' => 'full',
                    ],
                ],
                'body' => [
                    'type' => 'richtext-field',
                    'config' => [
                        'label' => 'Body',
                    ],
                ],
                'link' => [
                    'type' => 'relational-field',
                    'config' => [
                        'post_type' => 'posts',
                        'multiple' => false,
                        'if' => [
                            'title' => 'not empty',
                        ],
                    ],
                ],
            ],
        ];
    }
}
