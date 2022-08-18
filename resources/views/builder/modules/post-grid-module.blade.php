@extends('builder::module-base')
@php
  $postType = $module->has('post_type') ? $module->get('post_type')->value() : 'post';
  $taxonomy_link = $module->has('taxonomy') ? $module->get('taxonomy')->value() : 'category';
  $taxonomy_slug = $taxonomy_link ? preg_replace('/.*\//', '', $taxonomy_link) : 'category';
  $slider_type = $module->has('slider_type') ? $module->get('slider_type')->value() : 'slider-default';
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
  <div class="grid gap-3">
    @foreach($posts as $post)
      @include("child-theme::loop-templates.content-{$postType}", ['post' => $post, 'class' => 'g-col-4'])
    @endforeach
  </div>
@overwrite
