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

  @if($video_url = $column->getInlineAttribute("background.video_url"))
    @component('builder.components.background-video', ['background' => true, 'autoplay' => true, 'video_url' => $video_url, 'aspect_ratio' => '16/9', 'fullscreen' => true, 'muted' => true])@endcomponent
  @endif

  @if($column->getInlineAttribute('background.separate_element', false))
    @component('builder.components.background-image-element', [
      'background' => $column->getInlineAttribute('background', [])
    ])@endcomponent
  @endif

  @foreach($column->modules() as $module)
    @if ($module)
      {!! $module->render() !!}
    @endif
  @endforeach
</div>
