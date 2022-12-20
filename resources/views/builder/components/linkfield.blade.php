{{-- props: $data, $class --}}
@php
  $url = $data['url'] ?? '';
  $title = $data['title'] ?? '';
  $target = (isset($data['target']) && !empty($data['target'])) ? $data['target'] : null;  
@endphp

<a 
  @if($class) class="{{ $class }}" @endif 
  @isset($target) target="{{ $target }}" @endisset 
  href="{{ $url }}">
  {{ $title }}
</a>