@php
  $text = $button['text'] ?? '';
  $bg_colour = isset($button['style']) ? "btn-{$button['style']}" : 'btn-primary';
  $size = $button['size'] ?? null;
  $color = isset($button['color']) ? "text-{$button['color']}" : null;
  $class = collect([])
    ->push('btn')
    ->push($bg_colour)
    ->push($size)
    ->push($color)
    ->filter()
    ->implode(' ');
  $url = $button['url']['url'] ?? '#';
@endphp

<a href="{{ $url }}" class="{{ $class }}">{!! __($text, 'buildystrap') !!}</a>