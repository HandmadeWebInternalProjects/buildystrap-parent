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
                    'type' => 'code-field',
                ],
            ],
        ];
    }
}
