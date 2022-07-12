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
                            'type' => 'text-field',
                            'config' => [
                                'input_type' => 'text',
                                'label' => 'Title',
                            ],
                        ],
                        'show' => [
                            'type' => 'radio-buttons-field',
                            'config' => [
                                'label' => 'Show',
                                'options' => ['image', 'cta'],
                                'taggable' => true,
                                'multiple' => true,

                            ],
                        ],
                        'image' => [
                            'type' => 'media-field',
                            'config' => [
                                'label' => 'Image',
                                'multiple' => false,
                                'if' => [
                                  'show' => 'equals image'
                                ]
                            ],
                        ],
                        'cta' => [
                            'type' => 'button-field',
                            'config' => [
                                'label' => 'Call to action',
                                'if' => [
                                  'show' => 'equals cta'
                                ]
                            ],
                        ],
                    ],
                    'config' => [
                      'preview' => 'title',
                    ]
                ],
            ],
        ];
    }

    protected function augment(): void
    {
    }
}
