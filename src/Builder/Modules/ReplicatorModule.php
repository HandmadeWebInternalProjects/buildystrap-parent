<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Illuminate\Support\Collection;

use function collect;

class ReplicatorModule extends Module
{
    protected function augment(): void
    {
    }

    public static function blueprint(): Collection
    {
        return collect([
            'icon' => 'fa-solid fa-magic-wand-sparkles',
            'fields' => [
              'set_handle' => [
              'type' => 'replicator-field',
              'handle'=> 'set_handle',
              'fields' => [
                'title' => [
                  'type' => "text-field",
                  'handle' => "title",
                  'config' => [
                    'input_type' => "text",
                    'display'=> "Title",
                  ]
                ],
                'role' => [
                  'type' => "checkboxes-field",
                  'handle' => "role",
                  'config' => [
                    'display' => "Role",
                    'options' => [ 'primary' => "Primary", 'secondary' => "Secondary" ],
                  ],
                ],
                'content' => [
                  'type' => "richtext-field",
                  'handle' => "content",
                  'config' => [
                    'display' => "Content",
                  ],
                ],
                'image' => [
                  'type' => "media-field",
                  'handle' => "image",
                  'config' => [
                    'display' => "Image",
                  ],
                ],
              ]
            ],
          ],
        ]);
    }
}
