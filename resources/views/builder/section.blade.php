@php
    $attrs = collect([
        'id' => $section->getAttribute('id'),
        'class' => $section->classes(),
        'style' => $section->inlineStyles(),
    ])->filter()
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
