@php
$text = $button['text'];
$url = $button['url'];
$class = collect([])
    ->push($button['style'] ?? 'btn-primary')
    ->push($button['size'] ?? '')
    ->filter()
    ->implode(' ');
$style = isset($button['color']) ? "--bs-btn-color: var(--bs-{$button['color']})" : '';

echo sprintf('<a href="%s" class="btn %s" style="%s">%s</a>', $url['url'], $class, $style, __($text, 'buildystrap'));
@endphp