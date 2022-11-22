@extends('builder::module-base')

@php
  $postType = $module->has('post_type') ? $module->get('post_type')->value() : 'post';
  $taxonomy = $module->has('taxonomy') ? $module->get('taxonomy')->value() : null;
  $taxonomy_slug = isset($taxonomy['slug']) ? $taxonomy['slug'] : 'category';
  $limit = $module->has('limit') ? $module->get('limit')->value() : 6;
  $offset = $module->has('offset') ? $module->get('offset')->value() : 0;
  $columns = $module->has('columns') ? $module->get('columns')->value() : 3;
  $exclude_cats = $module->has('exclude_cats') ? $module->get('exclude_cats')->value() : null;
  $exclude_cats = $exclude_cats ? explode(',', $exclude_cats) : null;
  $template_part = $module->has('template_part') ? $module->get('template_part')->value() : "loop-templates/content-$postType";
  $args = ['post_type' => $postType, 'numberposts' => $limit, 'offset' => $offset, 'category__not_in' => $exclude_cats];

  if ($module->get('term')->value()) {
    // add tax_query to args
    $args['tax_query'] = [
      [
        'taxonomy' => $taxonomy_slug,
        'field' => 'id',
        'terms' => collect($module->get('term')->value())->implode(','),
      ]
    ];
  }

  $posts = get_posts($args);
@endphp

@section('field_content')
  <div class="grid gap-2 gap-md-3">
    @foreach($posts as $post)
      <div class="g-col-12 g-col-md-{{ 12 / $columns }}">
        @include($template_part, ['post' => $post])
      </div>
    @endforeach
  </div>
@overwrite
