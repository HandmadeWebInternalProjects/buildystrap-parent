<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class PostGridModule extends Module
{
    protected static function blueprint(): array
    {
      return [
        'icon' => 'fa-solid fa-paragraph',
        'fields' => [
          'post_type' => [
            'type' => 'relational-field',
            'config' => [
              'label' => 'Post Type',
              'endpoint' => 'wp/v2/types',
              'return_value' => 'slug',
              'return_label' => 'slug',
              'allow_null' => true,
            ],
          ],
          'taxonomy' => [
            'type' => 'relational-field',
            'config' => [
              'label' => 'Taxonomy',
              'class' => 'g-col-6',
              'depends_on' => 'post_type',
              'data_type' => 'taxonomies',
              'return_values' => [
                ['slug' => 'slug'],
                ['terms_link' => '_links.wp:items.0.href']
              ],
              'return_label' => 'slug',
              'allow_null' => true,
            ],
          ],
          'term' => [
            'type' => 'relational-field',
            'config' => [
              'label' => 'Term',
              'class' => 'g-col-6',
              'depends_on' => 'taxonomy.terms_link',
              'data_type' => 'endpoint',
              'return_value' => 'id',
              'return_label' => 'slug',
              'multiple' => true,
              'allow_null' => true,
            ],
          ],
          'limit' => [
            'type' => 'text-field',
            'config' => [
              'label' => 'Limit',
              'class' => 'g-col-6',
              'placeholder' => 6
            ],
          ],
          'offset' => [
            'type' => 'text-field',
            'config' => [
              'label' => 'Offset',
              'class' => 'g-col-6',
              'placeholder' => 0
            ],
          ],
          'columns' => [
            'type' => 'text-field',
            'config' => [
              'label' => 'Columns',
              'class' => 'g-col-6',
              'placeholder' => 3
            ],
          ],
          'template_part' => [
            'type' => 'text-field',
            'config' => [
              'label' => 'Template Part',
              'placeholder' => 'loop-templates/content',
            ],
          ],
        ],
      ];
    }
}
