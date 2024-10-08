
<div class="artist-card__media artist-card__media-image gallery-lightbox" data-uuid="general">
  @if(isset($mediaLightbox))
    <a class="lightbox-trigger" href="{{ $mediaLightbox }}">
      {!! $media !!}
    </a>
  @else 
    {!! $media !!}
  @endif
</div>