<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class PostGridModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-paragraph',
            'fields' => [
                'post_type' => [
                    'type' => 'relational-field',
                    'config' => [
                        'post_type' => 'types',
                        'return_value' => 'slug',
                        'return_label' => 'slug',
                        'allow_null' => true,
                    ],
                ],
            ],
        ];
    }
}
