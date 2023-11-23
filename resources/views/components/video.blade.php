@php
$video_url = $video_url ?? null;
$aspect_ratio = $aspect_ratio ?? '16/9';
$fullscreen = $fullscreen ?? false;
$autoplay = $autoplay ?? false;
$muted = $muted ?? false;
$additional_params = $additional_params ?? '';

if( ! function_exists('getVimeoVideoIdFromUrl') ) {
  function getVimeoVideoIdFromUrl($url = '') {
    $regs = array();
    $id = '';
    if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
      $id = $regs[3];
    }
    return $id;
  }
}

if( ! function_exists('getVimeoEmbedUrl') ) {
  function getVimeoEmbedUrl($url = '') {
    $id = getVimeoVideoIdFromUrl($url);
    return "https://player.vimeo.com/video/{$id}?title=0&byline=0&portrait=0";
  }
}

if( ! function_exists('getYoutubeVideoIdFromUrl') ) {
  function getYoutubeVideoIdFromUrl($url = '') {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    $id = $match[1];
    return $id;
  }
}

if( ! function_exists('getYoutubeEmbedUrl') ) {
  function getYoutubeEmbedUrl($url = '') {
    $id = getYoutubeVideoIdFromUrl($url);
    return "https://www.youtube.com/embed/{$id}?feature=oembed&rel=0&autohide=1&playlist={$id}";
  }
}

if( ! function_exists('getYoutubeThumbUrl') ) {
  function getYoutubeThumbUrl($url = '') {
    $id = getYoutubeVideoIdFromUrl($url);
    return 'https://img.youtube.com/vi/'. $id .'/maxresdefault.jpg';
  }
}

$video_type = match(true) {
  str_contains($video_url, 'youtube') => 'youtube',
  str_contains($video_url, 'vimeo') => 'vimeo',
  default => 'other'
};

$embed_url = match($video_type) {
  'youtube' => getYoutubeEmbedUrl($video_url),
  'vimeo' => getVimeoEmbedUrl($video_url),
  default => ''
};

$default_video_thumb = match($video_type) {
  'youtube' => getYoutubeThumbUrl($video_url),
  'vimeo' => '',
  default => ''
};
$video_thumb = isset($video_thumb) && $video_thumb ? wp_get_attachment_image_url($video_thumb, 'full') : $default_video_thumb;

$param_args = [];
if( $fullscreen ) {
  $param_args[] = 'fullscreen=1';
}
if( $autoplay ) {
  $param_args[] = 'autoplay=1&playsinline=1&loop=1&controls=0';
}
if( $muted ) {
  $param_args[] = 'mute=1';
}
if( !empty($additional_params) ) {
  $param_args[] = $additional_params;
}
$param_args = implode('&', $param_args);

if( ! empty($param_args) ) {
  // Check if ? in in the URL already and add the param args accordingly
  $embed_url = str_contains($embed_url, '?') ? $embed_url . '&' . $param_args : $embed_url . '?' . $param_args;
}
@endphp

@if(!empty($embed_url))
  <div class="video-container {{ $video_type }}" style="aspect-ratio: {{ $aspect_ratio }};">
    <div class="video-overlay rounded" style="@if (!empty($video_thumb)) {{ "--bg-image-url: url( $video_thumb );" }} @endif"> 
      <iframe
        class="video-iframe video-iframe--{{ $video_type }} rounded"
        data-src='{!! "$embed_url" !!}'
        src='{!! "$embed_url" !!}'
        width="100%"
        height="auto"
        frameborder="0"
        allow="false"
        allowfullscreen
        style="aspect-ratio: {{ $aspect_ratio }};">
      </iframe>
      @if (!$autoplay)
        <div class="video-overlay__contents">
          <a href="javascript:;" class="video-play">
            <span class="visually-hidden">Play video</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="124" height="125" viewBox="0 0 124 125" fill="none">
              <path d="M123 62.9713C123 96.66 95.6894 123.97 62 123.97C28.3106 123.97 1 96.66 1 62.9713C1 29.2827 28.3106 1.97266 62 1.97266C95.6894 1.97266 123 29.2827 123 62.9713Z" stroke="currentColor" stroke-width="2"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M49.459 87.7549L84.5591 67.2513C85.8333 66.5563 86.7601 65.0504 86.7601 63.4286C86.7601 61.8069 85.9492 60.301 84.6749 59.6059L49.459 39.1023C48.1847 38.4073 46.3312 38.4073 45.057 39.1023C43.7827 39.7974 42.856 41.3033 42.856 42.925V83.9322C42.856 85.554 43.7827 87.0599 45.057 87.7549C45.752 88.2183 46.5629 88.3341 47.258 88.3341C47.953 88.3341 48.7639 88.2183 49.459 87.7549Z" fill="currentColor"/>
            </svg>
          </a>
        </div>
      @endif
    </div>
  </div>
@endif