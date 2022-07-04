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
                            'type' => "text-field",
                            'config' => [
                                'input_type' => "text",
                                'label' => "Title",
                            ],
                        ],
                        'role' => [
                            'type' => "select-field",
                            'config' => [
                                'label' => "Role",
                                'options' => ['primary' => "Primary", 'secondary' => "Secondary"],
                                'taggable' => true,
                                'multiple' => true
                            ],
                        ],
                        'magic' => [
                            'type' => "replicator-field",
                            'config' => [
                                'label' => "Content",
                            ],
                            'fields' => [
                                'name' => [
                                  'type' => "text-field",
                                  'config' => [
                                      'input_type' => "text",
                                      'label' => "Name",
                                  ],
                                ],
                                'bio' => [
                                    'type' => "richtext-field",
                                ],
                            ],
                            'preview' => 'name'
                        ],
                        'image' => [
                            'type' => "media-field",
                            'config' => [
                                'label' => "Image",
                                'multiple' => false,
                            ],
                        ],
                        'cta' => [
                            'type' => "button-field",
                            'config' => [
                                'label' => "Call to action",
                            ],
                        ],
                    ],
                ],
            ],
            'preview' => 'title'
        ];
    }

    protected function augment(): void
    {
    }
}
