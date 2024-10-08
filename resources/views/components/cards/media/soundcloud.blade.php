@php 
use Buildystrap\EmbedContext;

// $media is the URL
if (!isset($mediaLightbox)) {
  return '';
}

$context = new EmbedContext($mediaLightbox);
@endphp

<div class="soundcloud-player">
  <div class="bg-primary d-flex align-items-center justify-content-center gallery-lightbox" data-uuid="general">
    <a class="lightbox-trigger" href="{{ $context->embedUrl() }}">
      {!! wp_get_attachment_image(178, 'full') !!}
    </a>
  </div>
</div>