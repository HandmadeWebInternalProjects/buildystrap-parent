@php
    $attrs = collect([
        'id' => $column->getAttribute('id'),
        'class' => $column->classes(),
        'style' => $column->inlineStyles(),
    ])->merge($column->getDataAttributes())->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    @if($column->getInlineAttribute('background.separate_element', false))
      @component('builder.components.background-image-element', [
        'background' => $column->getInlineAttribute('background', [])
      ])@endcomponent
    @endif

    @foreach($column->modules() as $module)
        {!! $module->render() !!}
    @endforeach
</div>
