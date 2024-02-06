@php

  $attrs = collect([
      'id' => $section->getAttribute('id'),
      'class' => apply_filters('section-classes', $section->classes()),
      'style' => apply_filters('section-styles', $section->inlineStyles()),
  ])->merge($section->getDataAttributes())->filter()
  ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
  ->implode(' ');
  
@endphp

<div {!! $attrs !!}>

  @if($video_url = $section->getInlineAttribute("background.video_url"))
    @component('builder.components.background-video', ['background' => true, 'autoplay' => true, 'video_url' => $video_url, 'aspect_ratio' => '16/9', 'fullscreen' => true, 'muted' => true])@endcomponent
  @endif

  @if($section->getInlineAttribute('background.separate_element', false))
    @component('builder.components.background-image-element', [
      'background' => $section->getInlineAttribute('background', [])
    ])@endcomponent
  @endif

  {!! $section->getConfig('boxed_layout') ? '<div class="container">' : null !!}

    @foreach($section->rows() as $row)
        {!! $row->render() !!}
    @endforeach

    {!! $section->getConfig('boxed_layout') ? '</div>' : null !!}
</div>
