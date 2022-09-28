@extends('builder::module-base', ['class' => ''])

@section('field_content')

  @php
      $col_count = $module->has('columns') ? collect($module->get('columns')->value())->map(function($value, $key) {
        $prefix = ($key !== 'xs') ? "-$key" : null;
        if (!isset($value)) {
          return null;
        }
        return (12 % (int) $value === 0) ? null : "--bs$prefix-columns: $value;";
      })->filter()->join('') : null;

      $col_class = getResponsiveClasses(module: $module, prop: 'columns', classPrefix: 'g-col', fallback: 'g-col-4', computed: fn($val) => isset($val) ? (((int) $val && 12 % $val === 0) ? (12 / (int) $val) : 1) : null);
      $col_gap = getResponsiveClasses(module: $module, prop: 'col_gap', classPrefix: 'gap', fallback: 'gap-3');
      $place_items = getResponsiveClasses(module: $module, prop: 'place_items', classPrefix: 'place-items', fallback: '');
      $image_size = $module->has('image_size') ? $module->get('image_size')->value() : 'medium';
  @endphp

  <div class="grid {{ $col_gap }} {{ $place_items }}" @if($col_count) style="{{ $col_count }}" @endif>
    @if($module->has('images'))
      @foreach($module->get('images')->value() as $image)
        <div class="{{ $col_class }}">
          {!! wp_get_attachment_image($image['id'], $image_size) !!}
        </div>
      @endforeach
    @endif
  </div>
    
@overwrite