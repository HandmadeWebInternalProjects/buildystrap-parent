<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class ReplicatorModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-magic-wand-sparkles',
            'fields' => [
                'set_handle' => [
                    'type' => 'replicator-field',
                    'fields' => [
                        'title' => [
                            'type' => "title-field",
                            'config' => [
                                'input_type' => "text",
                                'label' => "Title",
                            ],
                        ],
                        'role' => [
                            'type' => "checkboxes-field",
                            'config' => [
                                'label' => "Role",
                                'options' => ['primary' => "Primary", 'secondary' => "Secondary"],
                            ],
                        ],
                        'content' => [
                            'type' => "richtext-field",
                            'config' => [
                                'label' => "Content",
                            ],
                        ],
                        'image' => [
                            'type' => "media-field",
                            'config' => [
                                'label' => "Image",
                                'multiple' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function augment(): void
    {
    }
}
