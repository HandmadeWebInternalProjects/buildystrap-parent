@php
    $attrs = collect([
        'id' => $module->getAttribute('id'),
        'class' => $module->classes()
    ])->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    <h2>{!! $module->fields()->get('title') !!}</h2>

    @if($module->fields()->get('url'))
        <a href="{{ $module->fields()->get('url') }}">{{ $module->fields()->get('url') }}</a>
    @endif

    {!! $module->fields()->get('body') !!}
</div>
