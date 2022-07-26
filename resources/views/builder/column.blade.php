@php
    $attrs = collect([
        'id' => $column->getAttribute('id'),
        'class' => $column->classes()
    ])->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    @foreach($column->modules() as $module)
        {!! $module->render() !!}
    @endforeach
</div>
