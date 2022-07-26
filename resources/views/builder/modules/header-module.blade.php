@php
    $attrs = collect([
        'id' => $module->getAttribute('id'),
        'class' => $module->classes()
    ])->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    <h1>{!! $module->fields()->get('title') !!}</h1>
</div>
