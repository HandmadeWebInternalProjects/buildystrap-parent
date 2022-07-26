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
                    'type' => 'title-field',
                    'config' => [
                        'label' => 'Heading',
                        'tinymce' => [
                          'toolbar1' => 'bold,italic,underline',
                          'toolbar2' => false,
                          'height' => '20',
                          'autoresize_min_height' => '20',
                          'resize' => false,
                          'menubar' => false,
                          'statusbar' => false
                        ],
                    ],
                ],
            ],
        ];
    }

    public function augment(): void
    {
    }
}
