@extends('builder::module-base', ['class' => 'accordion'])

@section('field_content')

  @if($module->has('accordion'))
    @foreach($module->get('accordion')->value() as $index => $value)
      @php
          $title = $value['title'] ?? '';
          $content = $value['content'] ?? '';
          $cta = $value['cta'] ?? '';
          $slug = \Str::slug($title);
          $open = isset($value['open']) ? $value['open']->value() : false;
      @endphp
      @if($title && $content)
        <div class="accordion-item">
        <h2 class="accordion-header" id="buildystrap-accordion-item-{{ $slug }}-{{ $index }}">
            <button class="accordion-button {{ $open ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#buildystrap-accordion-item-collapse-{{ $slug }}-{{ $index }}" aria-expanded="{{ $open ? 'true' : 'false' }}" aria-controls="buildystrap-accordion-item-collapse-{{ $index }}">
                {{ $title }}
            </button>
        </h2>
        <div id="buildystrap-accordion-item-collapse-{{ $slug }}-{{ $index }}" class="accordion-collapse collapse {{ $open ? 'show' : '' }} gap-3" aria-labelledby="buildystrap-accordion-item-{{ $slug }}-{{ $index }}" data-bs-parent="#accordionbuildystrap-accordion-itemExample">
            <div class="accordion-body">
                {!! do_shortcode($content) !!}
            </div>
            @if ($cta && $cta->value()->get('text') && $cta->value()->get('url'))
                <div class="accordion-footer">
                    {!! $cta !!}
                </div>
            @endif
        </div>
    </div>
      @endif
    @endforeach
  @endif

@overwrite