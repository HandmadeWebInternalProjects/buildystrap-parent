@extends('builder::module-base', ['class' => 'w-100'])

@php

$options = get_slider_options($module);
@endphp

@section('field_content')
  @if($module->has('slides'))
  <div class="swiper" data-options="{{ json_encode($options) }}">
    <div class="swiper-wrapper max-w-100">
        @foreach($module->get('slides')->value() as $slide)
          <div class="swiper-slide">
            @php
              $image = collect($slide['image'] ?? [])->first();
              $title = $slide['title'] ?? null;
              $body = $slide['body'] ?? null;
            @endphp
            <?= wp_get_attachment_image($image['id'] ?? null, 'full', false, ['class' => 'w-100 rounded']); ?>
            @isset($body)
              <div class="slider-body">
                <h3 class="slider-title">{!! $title !!}</h3>
                <p class="slider-text">{!! $body !!}</p>
              </div>
            @endisset
          </div>
        @endforeach
    </div>

    @if(isset($options['pagination']) && $options['pagination'] !== "false")
      <div class="swiper-pagination"></div>
    @endif

    @if($has_navigation)
      <!-- If we need navigation buttons -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    @endif
      </div>
  @endif
@overwrite
