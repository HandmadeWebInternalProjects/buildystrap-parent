<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class HeaderModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-heading',
            'fields' => [
                'title' => [
                    'type' => 'text-field',
                    'config' => [
                        'label' => 'Title text',
                    ],
                ],
            ],
        ];
    }

    protected function augment(): void
    {
    }
}
