<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Illuminate\Support\Collection;

use function collect;

class TextModule extends Module
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
                'title' => [
                    'type' => 'text-field',
                    'handle' => 'text',
                    'config' => [
                      'display' => 'First text',
                      'input_type' => 'email'
                    ]
                ],
                'another_text' => [
                    'type' => 'text-field',
                    'handle' => 'another_text',
                    'config' => [
                      'display' => 'Another Text'
                    ]
                ],
            ],
        ]);
    }
}
