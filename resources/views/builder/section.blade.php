@php
    $attrs = collect([
        'id' => $section->getAttribute('id'),
        'class' => apply_filters('section-classes', $section->classes()),
        'style' => apply_filters('section-styles', $section),
    ])->merge($section->getDataAttributes())->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
    
@endphp

<div {!! $attrs !!}>

  @if($section->getInlineAttribute('background.separate_element', false))
    @component('builder.components.background-image-element', [
      'background' => $section->getInlineAttribute('background', [])
    ])@endcomponent
  @endif

  {!! $section->getConfig('boxed_layout') ? '<div class="container">' : null !!}

    @foreach($section->rows() as $row)
        {!! $row->render() !!}
    @endforeach

    {!! $section->getConfig('boxed_layout') ? '</div>' : null !!}
</div>
