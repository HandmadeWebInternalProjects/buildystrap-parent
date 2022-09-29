<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class CodeModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-paragraph',
            'fields' => [
                'code' => [
                    'config' => [
                        'label' => 'Code',
                        'placeholder' => 'Insert code or scripts here.'
                    ],
                    'type' => 'code-field',
                ],
            ],
        ];
    }
}
