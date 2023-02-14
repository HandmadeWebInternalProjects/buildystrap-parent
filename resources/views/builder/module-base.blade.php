@php
    $attrs = collect([
        'id' => $module->getAttribute('id'),
        'class' => $module->classes( ! empty($class) ? $class : ''),
        'data-uuid' => ! empty($uuid) ? $uuid : '',
        'style' => $module->inlineStyles($style ?? ''),
    ])->merge($module->getDataAttributes())->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    @if($module->getInlineAttribute('background.separate_element', false))
      @component('builder.components.background-image-element', [
        'background' => $module->getInlineAttribute('background', [])
      ])@endcomponent
    @endif
    @yield('field_content')
</div>