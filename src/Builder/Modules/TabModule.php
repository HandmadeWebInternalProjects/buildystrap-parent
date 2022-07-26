<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class TabModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-equals',
            'fields' => [
                'tabs' => [
                    'type' => 'tab-field',
                    'config' => [
                        'label' => '',
                    ],
                ],
            ],
        ];
    }
}
