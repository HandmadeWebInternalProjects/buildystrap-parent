@php
    $attrs = collect([
        'id' => $module->getAttribute('id'),
        'class' => $module->classes( ! empty($class) ? $class : '')
    ])->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    @yield('field_content')
</div>