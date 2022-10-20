@php
  $text = $button['text'] ?? '';
  $style = $button['style'] ?? 'btn-primary';
  $size = $button['size'] ?? null;
  $color = $button['color'] ?? null;
  $target = $button['target'] ?? null;
  $class = collect([])
    ->push('btn')
    ->push($style)
    ->push($size)
    ->filter()
    ->implode(' ');
  $style = isset($color) ? "style='--bs-btn-color: var(--bs-{$color});'" : '';
  $url = $button['url']['url'] ?? '#';
@endphp

<a href="{{ $url }}" @isset($target) target="{{ $target }}" @endisset class="{{ $class }}" {{ $style }}>{!! __($text, 'buildystrap') !!}</a>