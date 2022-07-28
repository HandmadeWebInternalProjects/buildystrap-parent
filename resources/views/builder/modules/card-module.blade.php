@php
    $attrs = collect([
        'id' => $module->getAttribute('id'),
        'class' => $module->classes()
    ])->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    {!! $module->get('title') !!}

    {!! $module->get('image') !!}

    @if($module->has('link'))
        <a href="{{ $module->get('link') }}">{{ $module->get('link') }}</a>
    @endif

    {!! $module->get('body') !!}
</div>
