<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class ImageModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-images',
            'fields' => [
                'image' => [
                    'type' => 'media-field',
                    'config' => [
                        'label' => 'Images',
                        'multiple' => false,
                    ],
                ]
            ],
        ];
    }

    // public function augment(): void
    // {
    //     // Remember for modules to run
    //     parent::augment();
    // }
}
