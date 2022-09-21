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
                        'endpoint' => 'wp/v2/types',
                        'return_value' => 'slug',
                        'return_label' => 'slug',
                        'allow_null' => true,
                    ],
                ],
                'taxonomy' => [
                    'type' => 'relational-field',
                    'config' => [
                        'depends_on' => 'post_type',
                        'data_type' => 'taxonomies',
                        'return_value' => '_links.wp:items.0.href',
                        'return_label' => 'slug',
                        'allow_null' => true,
                    ],
                ],
                'term' => [
                    'type' => 'relational-field',
                    'config' => [
                        'depends_on' => 'taxonomy',
                        'data_type' => 'endpoint',
                        'return_value' => 'id',
                        'return_label' => 'slug',
                        'multiple' => true,
                        'allow_null' => true,
                    ],
                ],
                'template_part' => [
                    'type' => 'text-field',
                ],
            ],
        ];
    }
}
