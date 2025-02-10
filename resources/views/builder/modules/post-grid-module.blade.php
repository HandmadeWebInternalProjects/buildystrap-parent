@extends('builder::module-base')

@php
  $postType = $module->has('post_type') ? $module->get('post_type')->value() : 'post';
  $show_related = $module->has('show_related') ? $module->get('show_related')->value() : false;
  $taxonomy = $module->has('taxonomy') ? $module->get('taxonomy')->value() : null;
  $taxonomy_slug = isset($taxonomy) ? collect($taxonomy)->pluck('slug') : null;
  $taxonomy_term = $module->has('term') ? $module->get('term')->value() : null;
  $taxonomy_relation = $module->has('taxonomy_relation') ? $module->get('taxonomy_relation')->value() : 'AND';
  $term_relation = $module->has('term_relation') ? $module->get('term_relation')->value() : 'AND';
  $meta_query = $module->has('meta_query') ? $module->get('meta_query')->value() : null;  
  $limit = $module->has('limit') ? $module->get('limit')->value() : 6;
  $offset_start = $module->has('offset') ? $module->get('offset')->value() : 0;
  $columns = $module->has('columns') ? $module->get('columns')->value() : 3;
  $column_class = $module->has('column_class') ? $module->get('column_class')->value() : "";
  $template_class = $module->has('template_class') ? $module->get('template_class')->value() : "";
  $column_str = get_responsive_classes(module: $module, prop: 'columns', classPrefix: 'grid-cols', fallback: 'grid-cols-3');
  $gap = get_responsive_classes(module: $module, prop: 'gap', classPrefix: 'gap', fallback: 'gap-2 gap-md-3');
  $exclude_cats = $module->has('exclude_cats') ? $module->get('exclude_cats')->value() : null;
  $exclude_cats = $exclude_cats ? explode(',', $exclude_cats) : null;
  $exclude_posts = $module->has('exclude_posts') ? $module->get('exclude_posts')->value() : null;
  $exclude_posts = $exclude_posts ? explode(',', $exclude_posts) : null;
  $orderby = $module->has('orderby') ? $module->get('orderby')->value() : 'menu_order date';
  $order = $module->has('order') ? $module->get('order')->value() : 'DESC';
  $enable_pagination = $module->has('enable_pagination') ? $module->get('enable_pagination')->value() : false;

  // Set a few fallbacks
  $template_part = [
    "loop-templates/content-$postType",
    "components/$postType-card",
    "components/cards/post-card",
    "components/post-card"
  ];

  if ($module->has('template_part')) {
    // If this was defined, at it to the beginning of the array
    array_unshift($template_part, $module->get('template_part')->value());
  }

  $enable_pagination = ($enable_pagination && $limit !== -1);
  if($enable_pagination) {
    $current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $current_page = max(1, $current_page);
    $offset = ($current_page - 1) * $limit + $offset_start;
  } else {
    $offset = $offset_start;
  }

  $args = [
    'post_type' => $postType, 
    'posts_per_page' => $limit, 
    'post_status' => 'publish',
    'offset' => $offset, 
    'orderby' => $orderby,
    'order' => $order,
  ];
  

  if ($show_related) {
    $args['tax_query'] = [
      'relation' => 'OR',
    ];
    $taxonomies = get_post_taxonomies(get_the_ID());
    foreach ($taxonomies as $taxonomy) {
      $terms = wp_get_post_terms(get_the_ID(), $taxonomy, ['fields' => 'ids']);
      $args['tax_query'][] = [
        'taxonomy' => $taxonomy,
        'field' => 'term_id',
        'terms' => $terms,
      ];
    }
  } else {
    if ($taxonomy_slug) {
      $args['tax_query'] = [
        'relation' => $taxonomy_relation,
      ];
      foreach ($taxonomy_slug as $slug) {
        $terms = $taxonomy_term ? collect($taxonomy_term)->where('taxonomy', $slug)->pluck('id') : null;
        array_push($args['tax_query'], [
          'taxonomy' => $slug,
          'field' => 'term_id',
          'operator' => $term_relation,
          'terms' => collect($terms)->toArray(),
        ]);
      }
    }
    if ($meta_query) {
      $args['meta_query'] = [
        'relation' => 'AND',
      ];
      foreach ($meta_query as $meta) {
        $meta_key = $meta['meta_key'];
        $meta_value = $meta['meta_value'];

        if (!is_array($meta_value)) {
          $meta_value = [$meta_value];
        }

        $field = get_field_object($meta_key['key']);  

        $field['parent_name'] = '';
        if ($field['parent'] ?? false) {
            // This needs work. Repeaters won't work currently. 
            $parent = acf_get_field($field['parent']);
            if ($field['type'] === 'repeater') {
              $meta_parent = $parent ? $parent['name'] . '_$_' : '';
            } else {
              $meta_parent = $parent ? $parent['name'] . '_' : '';
            }
            $meta_key['name'] = $meta_parent . $meta_key['name'];
        }

        foreach ($meta_value as $value) {
          // This needs work. Repeaters won't work currently. 
          if (strpos($meta_key['name'], '$') !== false) {
            $args['meta_query'][] = [
              'key' => $meta_key['name'],
              'value' => '"'. $value .'"',
              'compare' => 'LIKE',
            ];
          } else {
            $args['meta_query'][] = [
              'key' => $meta_key['name'],
              'value' => $value,
              'compare' => 'LIKE',
            ];
          }
        }      
      }
    }
    //dd($args['meta_query']);
  }

  // Include categories
  if (is_category()) {
    $category = get_queried_object();
    if( $category->taxonomy == 'category' ){
      $args['category__in'] = [ $category->term_id ];
    }
  }

  // Exclude categories
  if ($exclude_cats) {
    $args['category__not_in'] = $exclude_cats;
  }

  // Exclude posts
  if ($exclude_posts) {
    $args['post__not_in'] = $exclude_posts;
  }

  // Enable pagination
  if ($enable_pagination) {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args['paged'] = $paged;
  }

  $query = new WP_Query($args);
  $total_rows = max(0, $query->found_posts - $offset_start);
  $total_pages = ceil($total_rows / $limit);
@endphp

@section('field_content')
  @if ($query->have_posts())
    <div class="grid {{ $column_str }} {{ $gap }}">
      @while ($query->have_posts())
        @php $query->the_post(); @endphp
        <div class="{{ $column_class }}">
          @php 
            echo view()->first($template_part, ['post' => get_post(get_the_ID()), 'taxonomy' => $taxonomy_slug, 'class' => $template_class])->render();
          @endphp
        </div>
      @endwhile
      @php wp_reset_postdata(); @endphp
    </div>
    @if ($enable_pagination)
        <div class="d-flex mt-4 mt-lg-8 w-100 justify-content-center">
          {!! understrap_pagination([
            'prev_text' => '<i class="fas text-primary fa-arrow-left"></i>',
            'next_text' => '<i class="fas text-primary fa-arrow-right"></i>',
            'total' => $total_pages,
            ]) !!}
        </div>
      @endif
  @else
    <div>
      {{ __('No posts to display.', 'buildystrap-parent') }}
    </div>
  @endif
@overwrite
