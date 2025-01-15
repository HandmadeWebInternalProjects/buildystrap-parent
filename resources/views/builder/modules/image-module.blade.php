@php
  $lightbox_enabled =
      $module->has('enable_lightbox') && $module->get('enable_lightbox')->value() ? 'gallery-lightbox' : false;
@endphp

@extends('builder::module-base', ['class' => $lightbox_enabled, 'uuid' => $module->uuid()])

@php
  global $bodhi_svgs_options;
  $image = $module->has('image') ? $module->get('image')->value() : [];
  $link = $module->has('link') ? $module->get('link')->value() : false;
  $image_id = isset($image['image'])
      ? collect($image['image'])
          ->pluck('id')
          ->first()
      : '';
  $object_fit = isset($image['object_fit']) ? $image['object_fit'] : 'full';
  $object_position = isset($image['object_position']) ? $image['object_position'] : null;
  $image_size = $image['image_size'] ?? 'full';

  $classes = collect([
      isset($image['object_fit']) ? "object-{$image['object_fit']}" : 'full',
      isset($image['object_position']) ? "object-position-{$image['object_position']}" : null,
  ])
      ->filter()
      ->implode(' ');

  $width = isset($image['width']) ? "width: {$image['width']};" : '';
  $max_width = isset($image['max_width']) ? "max-width: {$image['max_width']};" : '';
  $height = isset($image['height']) ? "height: {$image['height']};" : '';
  $max_height = isset($image['max_height']) ? "max-height: {$image['max_height']};" : '';
  $inline_svg = isset($bodhi_svgs_options) && ($bodhi_svgs_options['force_inline_svg'] ?? false) == 'on' ? true : false;
  $inline_svg = $inline_svg && wp_check_filetype(wp_get_attachment_url($image_id))['ext'] == 'svg' ? true : false;
@endphp

@section('field_content')

  @if ($image_id)

    @if ($lightbox_enabled)
      @php $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?? null; @endphp
      <a href="{!! wp_get_attachment_image_url($image_id, $image_size) !!}" class="lightbox-trigger" data-glightbox="description:{{ $alt }}">
      @elseif($link)
        <a href="{{ $link['url'] ?? '#' }}" target="{{ $link['target'] ?? '_self' }}" title="{{ $link['title'] ?? '' }}">
    @endif
    @if ($inline_svg)
      <div class="svg-container" style="{{ trim("$width $max_width $height $max_height") }}">
    @endif
    {!! wp_get_attachment_image($image_id, $image_size, '', [
        'class' => $classes,
        'style' => trim("$width $max_width $height $max_height"),
    ]) !!}
    @if ($inline_svg)
      </div>
    @endif
    @if ($lightbox_enabled || $link)
      </a>
    @endif
  @endif

@overwrite
