<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use GFAPI;

class GravityFormsModule extends Module
{
  protected static function blueprint(): array
  {
    return [
      'icon' => 'fa-solid fa-envelope',
      'fields' => [
        'title' => [
          'type' => 'title-field',
          'config' => [
            'label' => 'Title',
          ],
        ],
        'form' => [
          'type' => 'select-field',
          'config' => [
            'label' => 'Form',
            'query' => [
              'type' => 'callback',
              'function' => [self::class, 'get_forms'],
            ]
          ],
        ],
      ],
      'config' => [
        'selectorTab' => 'regular'
      ]
    ];
  }

  public static function get_forms()
  {
    if (!class_exists('GFAPI')) {
      return [];
    }
    $forms = GFAPI::get_forms();

    $choices = collect($forms)->reduce(function ($carry, $item) {
      $carry[$item['title']] = $item['id'];
      return $carry;
    }, []);

    return $choices ?? [];
  }
}
