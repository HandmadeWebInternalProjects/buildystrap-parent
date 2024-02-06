@if($video_url)
  <div class="buildystrap-video-background z--1">
    @component('components.video', ['background' => true, 'autoplay' => true, 'video_url' => $video_url, 'aspect_ratio' => '16/9', 'fullscreen' => true, 'muted' => true])@endcomponent
  </div>
@endif