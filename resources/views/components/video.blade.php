@php

use Buildystrap\Factories\DefaultEmbedStrategyFactory;
use Buildystrap\EmbedContext;

$video_url = $video_url ?? null;
$aspect_ratio = $aspect_ratio ?? '16/9';
$fullscreen = $fullscreen ?? true;
$autoplay = $autoplay ?? false;
$mute = $muted ?? false;
$additional_params = $additional_params ?? '';
$playsinline = $autoplay;
$loop = $autoplay;
$controls = !$autoplay;
$background = $background ?? false;
$enablejsapi = $enablejsapi ?? true;

$params = collect(compact('fullscreen', 'background', 'autoplay', 'mute', 'playsinline', 'loop', 'additional_params', 'enablejsapi'))->filter()->map(function($value, $key) {
  return $key . '=' . $value;
})->implode('&');

// Instantiate the context with the default factory

try {
  $context = new EmbedContext(url: $video_url);
} catch (\Exception $e) {
  echo 'Huh, something went wrong. Please check the video URL.';
  return;
}


$video_type = $context->getVideoType();

$video_thumb = isset($video_thumb) && $video_thumb ? wp_get_attachment_image_url($video_thumb, 'full') : ($context->getThumb() ?? '');
@endphp

@if(!empty($video_url))
  <div class="video-container {{ strtolower($video_type) }}" style="aspect-ratio: {{ $aspect_ratio }};">
    <div class="video-overlay rounded" style="@if (!empty($video_thumb)) {{ "--bg-image-url: url( $video_thumb );" }} @endif aspect-ratio: {{ $aspect_ratio }};"> 
      {!! $context->embed($params) !!}
      @if (!$autoplay)
        <div class="video-overlay__contents">
          <a href="javascript:;" class="video-play">
            <span class="visually-hidden">Play video</span>
            {{-- You can add_filter in child theme to change the icon --}}
            {!! apply_filters( 'video-play-icon', '<svg xmlns="http://www.w3.org/2000/svg" width="124" height="125" viewBox="0 0 124 125" fill="none">
              <path d="M123 62.9713C123 96.66 95.6894 123.97 62 123.97C28.3106 123.97 1 96.66 1 62.9713C1 29.2827 28.3106 1.97266 62 1.97266C95.6894 1.97266 123 29.2827 123 62.9713Z" stroke="currentColor" stroke-width="2"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M49.459 87.7549L84.5591 67.2513C85.8333 66.5563 86.7601 65.0504 86.7601 63.4286C86.7601 61.8069 85.9492 60.301 84.6749 59.6059L49.459 39.1023C48.1847 38.4073 46.3312 38.4073 45.057 39.1023C43.7827 39.7974 42.856 41.3033 42.856 42.925V83.9322C42.856 85.554 43.7827 87.0599 45.057 87.7549C45.752 88.2183 46.5629 88.3341 47.258 88.3341C47.953 88.3341 48.7639 88.2183 49.459 87.7549Z" fill="currentColor"/>
            </svg>' ) !!}
          </a>
        </div>
      @endif
    </div>
  </div>
@endif