<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class ButtonModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-paragraph',
            'fields' => [
                'button' => [
                    'type' => 'button-field',
                ],
            ],
        ];
    }

    protected function augment(): void
    {
    }
}
