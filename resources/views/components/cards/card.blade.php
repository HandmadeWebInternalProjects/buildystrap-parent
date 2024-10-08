@props([
    'post' => null,
    'media' => null,
    'mediaLightbox' => null,
    'type' => 'image',
    'title',
    'titleLevel' => 'h4',
    'permalink' => null,
    'content' => null,
    'class' => '',
])

{{-- 
The following slots are available:
- beforeTitle
- afterTitle 
- tags
--}}

@php
  $wrapper_tag = $permalink ? 'a' : 'div';
@endphp

<{{ $wrapper_tag }} @if($permalink) href="{{ $permalink }}" @endif class="card media-card {{ $class }}">
  <div class="media-card__inner">
    @isset($media)
      <div class="media-card__media media-card__media-{{ $type }} position-relative">
        @if ($mediaLightbox)
          @component('components.cards.media.' . $type, ['media' => $media, 'mediaLightbox' => $mediaLightbox])
          @endcomponent
        @else
          @component('components.cards.media.' . $type, ['media' => $media])
          @endcomponent
        @endif
      </div>
    @endisset
    <div class="card-body media-card__content">
      @isset($beforeTitle)
        {!! $beforeTitle !!}
      @endisset
      <div class="d-flex">
        <{{ $titleLevel }} class="media-card__title">
          {!! $title ?? '' !!}
        </{{ $titleLevel }}>
      </div>
      @isset($afterTitle)
        {!! $afterTitle !!}
      @endisset
      @if(isset($content) && !empty($content))
        <div class="media-card__content">
          {!! $content !!}
        </div>
      @endisset
      @isset($tags)
        <div class="media-card__tags">
          {!! $tags !!}
        </div>
      @endisset
      @isset($bodyEnd)
        {!! $bodyEnd !!}
      @endisset
    </div>
  </div>
</{{ $wrapper_tag }}>