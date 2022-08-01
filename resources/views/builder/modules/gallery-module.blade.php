@extends('builder::module-base', ['class' => ''])

@section('field_content')

  @php
      $col_count = getResponsiveClasses(module: $module, prop: 'columns', classPrefix: 'g-col', fallback: 'g-col-4', computed: fn($val) => (12 / (int) $val) );
      $col_gap = getResponsiveClasses(module: $module, prop: 'col_gap', classPrefix: 'gap', fallback: 'gap-3');
      $image_size = $module->get('image_size')->value();
  @endphp

  <div class="grid {{ $col_gap }}">
    @if($module->has('images'))
      @foreach($module->get('images')->value() as $image)
        <div class="{{ $col_count }}">
          {!! wp_get_attachment_image($image->id, $image_size) !!}
        </div>
      @endforeach
    @endif
  </div>
    
@overwrite