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

  {!! $section->getConfig('boxed_layout') ? '<div class="container">' : null !!}

    @foreach($section->rows() as $row)
        {!! $row->render() !!}
    @endforeach

    {!! $section->getConfig('boxed_layout') ? '</div>' : null !!}
</div>
