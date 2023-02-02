<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class VideoModule extends Module
{
  protected static function blueprint(): array
  {
    return [
      'icon' => 'fa-solid fa-play',
      'fields' => [
        'video_url' => [
          'config' => [
            'label' => 'Video URL',
          ],
          'type' => 'text-field',
        ],
        'video_thumb' => [
          'type' => 'media-field',
          'config' => [
            'label' => 'Thumbnail Image',
            'size' => 'full',
            'if' => [
              'video_url' => 'contains youtube',
            ],
          ],
        ],
        'params' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Params',
            'placeholder' => 'autoplay=1&mute=1',
          ],
        ],
        'aspect_ratio' => [
          'type' => 'select-field',
          'config' => [
            'label' => 'Aspect Ratio',
            'placeholder' => 'Default',
            'options' => [
              '1/1',
              '4/3',
              '16/9',
              '16/10'
            ],
            'taggable' => true,
          ],
        ],
      ],
    ];
  }
}
