@php
  $hasType = isset($button['type']) && $button['type'] !== 'custom';

  $text = $button['text'] ?? '';
  $type = $hasType ? $button['type'] : 'btn-primary';
  $size = isset($button['size']) ? $button['size'] : null;
  $bg_colour = isset($button['style']) && !$hasType ? "btn-{$button['style']}" : '';
  $color = isset($button['color']) && !$hasType ? "text-{$button['color']}" : null;
  $target = isset($button['target']) && $button['target'] ? '_blank' : null;
  $btn_class = isset($button['class']) ? $button['class'] : null;
  $class = collect([])
    ->push('btn')
    ->push($btn_class)
    ->push($bg_colour)
    ->push($type)
    ->push($size)
    ->push($color)
    ->filter()
    ->implode(' ');
  $url = $button['url']['url'] ?? '#';
@endphp

<a href="{{ $url }}" @isset($target) target="{{ $target }}" @endisset class="{{ $class }}">{!! __($text, 'buildystrap') !!}</a>