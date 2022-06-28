<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Illuminate\Support\Collection;

use function collect;

class HeaderModule extends Module
{
    protected function augment(): void
    {
        if ( ! false) {
            ['icon' => 'fa-solid fa-magic-wand-sparkles'];
        }
    }

    public static function blueprint(): Collection
    {
        return collect([
            'icon' => 'fa-solid fa-paragraph',
            'fields' => [
                'text' => [
                    'type' => 'text-field',
                    'handle' => 'text',
                    'config' => [
                      'display' => 'First text',
                      'input_type' => 'email'
                    ]
                ],
                'another_text' => [
                    'type' => 'checkboxes-field',
                    'handle' => 'another_text',
                    'config' => [
                      'options' => ['Another Text' => 'test']
                    ]
                ],
            ],
        ]);
    }
}
