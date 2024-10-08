@php 
use Buildystrap\EmbedContext;

// $media is the URL
if (!isset($mediaLightbox)) {
  return '';
}

$context = new EmbedContext($mediaLightbox);
@endphp

<div class="vimeo-player gallery-lightbox" data-uuid="general">
  @if(isset($mediaLightbox))
    <a class="lightbox-trigger" href="{{ $mediaLightbox }}">
      <x-video-thumb :context="$context" />
    </a>
  @else 
    {!! $media !!}
  @endif
</div>