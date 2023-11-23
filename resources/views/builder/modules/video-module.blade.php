@extends('builder::module-base', ['class' => ''])

@section('field_content')

  @php
  $video_url = $module->has('video_url') ? $module->get('video_url')->value() : null;
  $video_thumb = $module->has('video_thumb') ? collect($module->get('video_thumb')->value())->pluck('id')->first() : '';
  $params = $module->has('params') ? $module->get('params')->value() : '';
  $fullscreen = $module->has('fullscreen') ? $module->get('fullscreen')->value() : false;
  $autoplay = $module->has('autoplay') ? $module->get('autoplay')->value() : false;
  $muted = $module->has('muted') ? $module->get('muted')->value() : false;
  $aspect_ratio = $module->has('aspect_ratio') ? $module->get('aspect_ratio')->value() : '16/9';
  @endphp

  @component('components.video', compact('video_url', 'video_thumb', 'params', 'fullscreen', 'autoplay', 'muted', 'aspect_ratio' )) @endcomponent

@overwrite