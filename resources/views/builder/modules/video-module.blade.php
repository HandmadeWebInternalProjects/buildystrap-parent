@php
$video_url = $module->has('video_url') ? $module->get('video_url')->value() : null;
$aspect_ratio = $module->has('aspect_ratio') ? $module->get('aspect_ratio')->value() : '16:9';

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

$video_thumb = $module->has('video_thumb') ? collect($module->get('video_thumb')->value())->pluck('id')->first() : '';
$video_thumb = $video_thumb ? wp_get_attachment_image_url($video_thumb, 'full') : $default_video_thumb;
@endphp

@extends('builder::module-base', ['class' => ''])

@section('field_content')

  @if(!empty($embed_url))
    <div class="video-container {{ $video_type }}" style="aspect-ratio: {{ $aspect_ratio }};">
      <div class="video-overlay rounded" style="@if (!empty($video_thumb)) {{ "background-image: url( $video_thumb );" }} @endif"> 
        <iframe
          class="video-iframe video-iframe--{{ $video_type }} rounded"
          data-src="{!! $embed_url !!}"
          src="{!! $embed_url !!}"
          width="100%"
          height="auto"
          frameborder="0"
          allow="false"
          allowfullscreen
          style="aspect-ratio: {{ $aspect_ratio }};">
        </iframe>
        <div class="video-overlay__contents">
          <a href="javascript:;" class="video-play">
            <span class="sr-only">Play video</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="0.88em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 448 512"><path fill="currentColor" d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"/></svg>
          </a>
        </div>
      </div>
    </div>
  @endif

@overwrite