@extends('builder::module-base', ['class' => 'w-100'])

@php

$options = [
    'breakpoints' => [
      0 => [
        'slidesPerView' => 1,
        'spaceBetween' => 20,
      ],
      980 => [
        'slidesPerView' => $module->has('slidesPerView') ? $module->get('slidesPerView')->value() : 1,
        'spaceBetween' => $module->has('spaceBetween') ? (int) $module->get('spaceBetween')->value() : 30,
      ],
    ],
  ];

  if ($module->has('additional_settings')) {
    // $options = array_merge($options[], collect($module->get('additional_settings')->value())->pluck('value', 'name')->toArray());
    collect($module->get('additional_settings')->value())->each(function ($setting) use (&$options) {
      $value = maybe_nested($setting['name'], $setting['value']);
      
      if ($setting['breakpoint'] ?? false)
       {

          if (!is_array($value)) {
            $value = [$value];
          }

          $options['breakpoints'][$setting['breakpoint']] = array_merge_recursive(
            $options['breakpoints'][$setting['breakpoint']] ?? [],
            $value
          );
       }

      if (is_array($value)) {
        $options = array_merge_recursive($options, $value);
      }
    });
  }
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

    @if(isset($options['navigation']) && $options['navigation'] !== "false")
      <!-- If we need navigation buttons -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    @endif
      </div>
  @endif
@overwrite
