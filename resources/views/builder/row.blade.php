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

  @if($video_url = $row->getInlineAttribute("background.video_url"))
    @component('builder.components.background-video', ['background' => true, 'autoplay' => true, 'video_url' => $video_url, 'aspect_ratio' => '16/9', 'fullscreen' => true, 'muted' => true])@endcomponent
  @endif

  @if($row->getInlineAttribute('background.separate_element', false))
    @component('builder.components.background-image-element', [
      'background' => $row->getInlineAttribute('background', [])
    ])@endcomponent
  @endif

  @foreach($row->columns() as $column)
      {!! $column->render() !!}
  @endforeach
</div>
