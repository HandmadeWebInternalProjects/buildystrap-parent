<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class AccordionModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-equals',
            'fields' => [
                'accordion' => [
                    'type' => 'accordion-field',
                    'config' => [
                        'label' => '',
                    ],
                ],
            ],
        ];
    }

    protected function augment(): void
    {
    }
}
