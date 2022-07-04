<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class GalleryModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-paragraph',
            'fields' => [
                'images' => [
                    'type' => 'media-field',
                    'config' => [
                        'label' => 'Images',
                        'multiple' => true,
                    ],
                ],
            ],
        ];
    }

    protected function augment(): void
    {
    }
}
