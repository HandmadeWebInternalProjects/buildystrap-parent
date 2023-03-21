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
        'show_related' => [
          'type' => 'toggle-field',
          'config' => [
            'label' => 'Show Related?',
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
            'multiple' => true,
            'allow_null' => true,
            'if' => [
              'show_related' => 'equals false',
            ],
          ],
        ],
        'term' => [
          'type' => 'relational-field',
          'config' => [
            'label' => 'Term',
            'class' => 'g-col-6',
            'depends_on' => 'taxonomy.terms_link',
            'data_type' => 'endpoint',
            'return_values' => [
              ['id' => 'id'],
              ['taxonomy' => 'taxonomy'],
            ],
            'return_label' => 'slug',
            'multiple' => true,
            'allow_null' => true,
            'if' => [
              'show_related' => 'equals false',
            ],
          ],
        ],
        'taxonomy_relation' => [
          'type' => 'select-field',
          'config' => [
            'label' => 'Taxonomy Relation',
            'class' => 'g-col-6',
            'options' => [
              'AND' => 'AND',
              'OR' => 'OR',
            ],
            'placeholder' => 'AND',
            'if' => [
              'show_related' => 'equals false',
            ],
          ],
        ],
        'term_relation' => [
          'type' => 'select-field',
          'config' => [
            'label' => 'Term Relation',
            'class' => 'g-col-6',
            'options' => [
              'IN' => 'IN',
              'NOT IN' => 'NOT IN',
              'AND' => 'AND',
              'EXISTS' => 'EXISTS',
              'NOT EXISTS' => 'NOT EXISTS',
            ],
            'placeholder' => 'AND',
            'if' => [
              'show_related' => 'equals false',
            ],
          ],
        ],
        'meta_query' => [
          'type' => 'replicator-field',
          'config' => [
            'label' => 'Meta Query',
            'class' => 'g-col-12',
            'if' => [
              'show_related' => 'equals false',
            ],
            'popover' => 'Experimental: Automatically calculates based off the selected post type and taxonomies.'
          ],
          'fields' => [
            'meta_key' => [
              'type' => 'relational-field',
              'config' => [
                'label' => 'Meta Key',
                'class' => 'g-col-6',
                'depends_on' => 'post_type',
                'data_type' => 'endpoint',
                'endpoint' => '/wp-json/buildy/v1/get_fields/',
                'return_values' => [
                  ['name' => 'name'],
                  ['key' => 'key']
                ],
                'return_label' => 'label',
                'multiple' => false,
                'allow_null' => true,
              ],
            ],
            'meta_value' => [
              'type' => 'relational-field',
              'config' => [
                'label' => 'Meta Value',
                'class' => 'g-col-6',
                'depends_on' => 'meta_query.$.meta_key.key',
                'data_type' => 'endpoint',
                'endpoint' => '/wp-json/buildy/v1/get_field/',
                'return_value' => 'value',
                'return_label' => 'label',
                'multiple' => true,
                'allow_null' => true,
                'taggable' => true,
              ],
            ],
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
