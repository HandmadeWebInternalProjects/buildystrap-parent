@extends('builder::module-base', ['class' => 'accordion'])

@section('field_content')

  @if($module->has('accordion'))
    @foreach($module->get('accordion')->value() as $index => $value)
      @php
          $title = $value['title'] ?? '';
          $content = $value['content'] ?? '';
          $slug = \Str::slug($title)
      @endphp
      @if($title && $content)
        <div class="accordion-item">
          <h2 class="accordion-header" id="buildystrap-accordion-item-{{ $slug }}-{{ $index }}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#buildystrap-accordion-item-collapse-{{ $slug }}-{{ $index }}" aria-expanded="false" aria-controls="buildystrap-accordion-item-collapse-{{ $index }}">
              {{ $title }}
            </button>
          </h2>
          <div id="buildystrap-accordion-item-collapse-{{ $slug }}-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="buildystrap-accordion-item-{{ $slug }}-{{ $index }}" data-bs-parent="#accordionbuildystrap-accordion-itemExample">
            <div class="accordion-body">
              {!! do_shortcode($content) !!}
            </div>
          </div>
        </div>
      @endif
    @endforeach
  @endif

@overwrite