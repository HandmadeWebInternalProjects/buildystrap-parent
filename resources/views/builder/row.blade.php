@php
    $attrs = collect([
        'id' => $row->getAttribute('id'),
        'class' => $row->classes(),
        'style' => $row->inlineStyles(),
    ])->merge($row->getDataAttributes())->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    @if($row->getInlineAttribute('background.separate_element', false))
      @component('builder.components.background-image-element', [
        'background' => $row->getInlineAttribute('background', [])
      ])@endcomponent
    @endif

    @foreach($row->columns() as $column)
        {!! $column->render() !!}
    @endforeach
</div>
