@extends('builder::module-base')
@php
  $postType = $module->has('post_type') ? $module->get('post_type')->value() : 'post';
  $slider_type = $module->has('slider_type') ? $module->get('slider_type')->value() : 'slider-default';
  $template_part =  $module->has('template_part') ? $module->get('template_part')->value() : 'post';
  $args = ['post_type' => $postType];

  if ($module->has('term')) {
    $args['category'] = collect($module->get('term')->value())->implode(',');
  }
  
  $posts = get_posts($args);
@endphp

@section('field_content')
  @include("child-theme::global-templates.{$slider_type}", ['posts' => $posts, 'template_part' => $template_part])
@overwrite
