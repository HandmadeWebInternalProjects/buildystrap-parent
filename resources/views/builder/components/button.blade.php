@php
  $hasType = isset($button['type']) && $button['type'] !== 'custom';

  $text = $button['text'] ?? '';
  $type = $button['type'] ?? 'btn-primary';
  $size = isset($button['size']) ? $button['size'] : null;
  $bg_colour = isset($button['style']) && !$hasType ? "btn-{$button['style']}" : '';
  $color = isset($button['color']) && !$hasType ? "text-{$button['color']}" : null;
  $target = isset($button['target']) && $button['target'] ? '_blank' : null;
  $btn_class = isset($button['class']) ? $button['class'] : null;
  $btn_icon = isset($button['icon'])
      ? collect($button['icon'])
          ->pluck('id')
          ->first()
      : null;
  $class = collect([])->push('btn')->push($btn_class)->push($bg_colour)->push($type)->push($size)->push($color);

  if ($btn_icon) {
      $class->push('has-icon');
  }

  $class = $class->filter()->implode(' ');

  $url = $button['url']['url'] ?? '#';
@endphp

<a href="{{ $url }}" @isset($target) target="{{ $target }}" @endisset
  class="{{ $class }}">
  {!! __($text, 'buildystrap') !!}
  @isset($btn_icon)
    {!! wp_get_attachment_image($btn_icon, 'full', false, ['class' => 'h-fit object-cover']) !!}
  @endisset
</a>
