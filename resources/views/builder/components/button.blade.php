@php
  $text = $button['text'] ?? '';
  $bg_colour = $button['style'] ? "btn-{$button['style']}" : 'btn-primary';
  $size = $button['size'] ?? null;
  $color = $button['color'] ? "text-{$button['color']}" : null;
  $target = ($button['target'] ?? null) && $button['target'] ? '_blank' : null;
  $class = collect([])
    ->push('btn')
    ->push($bg_colour)
    ->push($size)
    ->push($color)
    ->filter()
    ->implode(' ');
  $url = $button['url']['url'] ?? '#';
@endphp

<a href="{{ $url }}" @isset($target) target="{{ $target }}" @endisset class="{{ $class }}">{!! __($text, 'buildystrap') !!}</a>