@php
    $attrs = collect([
        'id' => $wrapper->getAttribute('id'),
        'class' => $wrapper->classes(),
        'style' => $wrapper->inlineStyles(),
    ])->merge($wrapper->getDataAttributes())->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
  @foreach($container->sections() as $section)
    {!! $section->render() !!}
  @endforeach
</div>