@extends('builder::module-base')

@php
  $postType = $module->has('post_type') ? $module->get('post_type')->value() : 'post';
  $taxonomy = $module->has('taxonomy') ? $module->get('taxonomy')->value() : null;
  $taxonomy_slug = isset($taxonomy['slug']) ? $taxonomy['slug'] : 'category';
  $limit = $module->has('limit') ? $module->get('limit')->value() : 6;
  $offset_start = $module->has('offset') ? $module->get('offset')->value() : 0;
  $columns = $module->has('columns') ? $module->get('columns')->value() : 3;
  $column_class = $module->has('column_class') ? $module->get('column_class')->value() : "";
  $column_str = [];
  if (is_array($columns)) {
    foreach ($columns as $breakpoint => $value) {
        $value = $value ? 12 / $value : '';
        if ($value) {
          $column_str[] = match ($breakpoint) {
              'xs' => "g-col-{$value}",
              default => "g-col-{$breakpoint}-{$value}"
          };
        }
    }
  } else {
    $column_str[] = "g-col-12 g-col-md-{$columns}";
  }
  $column_str = implode(' ', $column_str);
  $exclude_cats = $module->has('exclude_cats') ? $module->get('exclude_cats')->value() : null;
  $exclude_cats = $exclude_cats ? explode(',', $exclude_cats) : null;
  $exclude_posts = $module->has('exclude_posts') ? $module->get('exclude_posts')->value() : null;
  $exclude_posts = $exclude_posts ? explode(',', $exclude_posts) : null;
  $orderby = $module->has('orderby') ? $module->get('orderby')->value() : 'menu_order date';
  $order = $module->has('order') ? $module->get('order')->value() : 'DESC';
  $enable_pagination = $module->has('enable_pagination') ? $module->get('enable_pagination')->value() : false;
  $template_part = $module->has('template_part') ? $module->get('template_part')->value() : "loop-templates/content-$postType";

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

  // Setup meta_query arguments
  $args['meta_query'] = [
      'relation' => 'AND',
  ];

  // Setup tax_query arguments
  $args['tax_query'] = [
      'relation' => 'AND',
  ];

  // Include terms ie. taxonomies
  if ($module->get('term')->value()) {
    // add tax_query to args
    $args['tax_query'][] = [
      [
        'taxonomy' => $taxonomy_slug,
        'field' => 'id',
        'terms' => collect($module->get('term')->value())->implode(','),
      ]
    ];
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
    <div class="grid gap-2 gap-md-3">
      @while ($query->have_posts()) 
        @php $query->the_post(); global $post; @endphp
        <div class="{{ $column_str }} {{ $column_class }}">
          @include($template_part, ['post' => $post])
        </div>
      @endwhile
      @if ($enable_pagination)
        <div class="pagination g-col-12">
          {!! paginate_links([
            'total'   => $total_pages,
            'current' => $current_page,
            'prev_text' => 'Prev',
            'next_text' => 'Next'
          ]) !!}
        </div>
      @endif
      @php wp_reset_query(); @endphp
      @php wp_reset_postdata(); @endphp
    </div>
  @else
    <div>
      {{ __('No posts to display.', 'buildystrap-parent') }}
    </div>
  @endif
@overwrite
