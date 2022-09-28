@extends('builder::module-base')

@php
  $postType = $module->has('post_type') ? $module->get('post_type')->value() : 'post';
  $taxonomy = $module->has('taxonomy') ? $module->get('taxonomy')->value() : null;
  $taxonomy_slug = isset($taxonomy['slug']) ? $taxonomy['slug'] : 'category';
  $template_part =  $module->has('template_part') ? $module->get('template_part')->value() : 'post';
  $args = ['post_type' => $postType, 'posts_per_page' => 6];

  if ($module->has('term')) {
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
  <div class="grid gap-5">
    @foreach($posts as $post)
      <div class="g-col-md-4">
        @include("loop-templates.content-{$postType}", ['post' => $post])
      </div>
    @endforeach
  </div>
@overwrite
