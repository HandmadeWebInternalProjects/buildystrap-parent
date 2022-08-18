@extends('builder::module-base', ['class' => '' ])

@php
    $image = $module->has('image') ? $module->get('image')->value() : [];
    $image_id = isset($image['image']) ? collect($image['image'])->pluck('id')->first() : '';
    $object_fit = isset($image['object_fit']) ? $image['object_fit'] : 'full';
    
    $width = isset($image['width']) ? "width: {$image['width']};" : '';
    $max_width = isset($image['max_width']) ? "max-width: {$image['max_width']};" : '';
    $height = isset($image['height']) ? "height: {$image['height']};" : '';
    $max_height = isset($image['max_height']) ? "max-height: {$image['max_height']};" : '';
@endphp

@section('field_content')

    @if($image_id)
      {!! wp_get_attachment_image($image_id, 'full', '', ["class" => "object-{$object_fit}", "style" => trim("$width $max_width $height $max_height")]) !!}
    @endif
    
@overwrite