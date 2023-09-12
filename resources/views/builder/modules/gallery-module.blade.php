@php
$lightbox_enabled = ($module->has('enable_lightbox') && $module->get('enable_lightbox')->value()) ? 'gallery-lightbox' : false;
@endphp

@extends('builder::module-base', ['class' => $lightbox_enabled, 'uuid' => $module->uuid()])

@section('field_content')

  @php
      $col_count = $module->has('columns') ? collect($module->get('columns')->value())->map(function($value, $key) {
        $prefix = ($key !== 'xs') ? "-$key" : null;
        if (!isset($value)) {
          return null;
        }
        return (12 % (int) $value === 0) ? null : "--bs$prefix-columns: $value;";
      })->filter()->join('') : null;

      $col_class = get_responsive_classes(module: $module, prop: 'columns', classPrefix: 'g-col', fallback: 'g-col-4', computed: fn($val) => isset($val) ? (((int) $val && 12 % $val === 0) ? (12 / (int) $val) : 1) : null);
      $col_gap = get_responsive_classes(module: $module, prop: 'col_gap', classPrefix: 'gap', fallback: 'gap-3');
      $place_items = get_responsive_classes(module: $module, prop: 'place_items', classPrefix: 'place-items', fallback: '');
      $image_size = $module->has('image_size') ? $module->get('image_size')->value() : 'medium';
      $image_aspect_ratio = $module->has('image_aspect_ratio') ? $module->get('image_aspect_ratio')->value() : '';
      $image_style = $image_aspect_ratio ? "aspect-ratio: {$image_aspect_ratio}; object-fit: cover;" : '';
  @endphp

  <div class="grid {{ $col_gap }} {{ $place_items }}" @if($col_count) style="{{ $col_count }}" @endif>
    @if($module->has('images'))
      @foreach($module->get('images')->value() as $image)
      @php
        $image_link = bs_get_field('image_link', $image['id']);
      @endphp
        <div class="{{ $col_class }}">
          @if($image_link)
            <a href="{{ $image_link }}" target="_blank">
          @elseif($lightbox_enabled)
            @php $alt = get_post_meta($image['id'], '_wp_attachment_image_alt', true) ?? null; @endphp
            <a href="{!! wp_get_attachment_image_url($image['id'], 'full') !!}" class="lightbox-trigger" data-glightbox="description:{{ $alt }}">
          @endif
              {!! wp_get_attachment_image($image['id'], $image_size, '', ['class' => 'rounded w-100 h-auto', 'style' => $image_style]) !!}
          @if($image_link || $lightbox_enabled)
            </a>
          @endif
        </div>
      @endforeach
    @endif
  </div>
    
@overwrite