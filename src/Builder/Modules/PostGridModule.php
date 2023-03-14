<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;

class PostGridModule extends Module
{
  protected static function blueprint(): array
  {
    return [
      'icon' => 'fa-solid fa-grip',
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
            'return_value' => ['id', 'taxonomy'],
            'return_label' => ['slug', 'taxonomy'],
            'multiple' => true,
            'allow_null' => true,
          ],
        ],
        'limit' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Limit / Posts Per Page',
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
        'exclude_cats' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Exclude Category IDs (comma separated)',
            'class' => 'g-col-6',
            'placeholder' => ''
          ],
        ],
        'exclude_posts' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Exclude Post IDs (comma separated)',
            'class' => 'g-col-6',
            'placeholder' => ''
          ],
        ],
        'orderby' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Orderby',
            'class' => 'g-col-6',
            'placeholder' => 'menu_order date'
          ],
        ],
        'order' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Order',
            'class' => 'g-col-6',
            'placeholder' => 'DESC'
          ],
        ],
        'enable_pagination' => [
          'type' => 'toggle-field',
          'config' => [
            'label' => 'Enable Pagination?',
            'class' => 'g-col-12',
          ],
        ],
        'columns' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Columns',
            'class' => 'g-col-6',
            'responsive' => true
          ],
        ],
        'column_class' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Column Classes',
            'class' => 'g-col-6'
          ],
        ],
        'template_part' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Template Part',
            'placeholder' => 'loop-templates/content',
          ],
        ],
        'template_class' => [
          'type' => 'text-field',
          'config' => [
            'label' => 'Template Classes',
          ],
        ],
      ],
      'config' => [
        'selectorTab' => 'regular'
      ]
    ];
  }
}
