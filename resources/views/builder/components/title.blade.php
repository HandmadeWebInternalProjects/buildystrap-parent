@php
$level = $title['level'] ?? '';
$level = !empty($level) ? $level : 'h3';
$text = $title['text'] ?? '';
$size = [];
$size_vars = [];
$color = [];
$weight = [];
$class = $title['title_class'] ?? '';

foreach ($title['size'] as $breakpoint => $value) {
    if ($value) {
        $is_heading = in_array($value, ['1', '2', '3', '4', '5', '6']);
        $is_display = in_array($value, ['display-1', 'display-2', 'display-3', 'display-4', 'display-5', 'display-6']);

        if ($is_heading || $is_display) {
            if ($is_heading) {
                $size[] = match ($breakpoint) {
                    'xs' => "fs-{$value}",
                    default => "fs-{$breakpoint}-{$value}"
                };
            }
            if ($is_display) {
                $size[] = match ($breakpoint) {
                    'xs' => "display-" . str_replace('display-', '', $value),
                    default => "display-{$breakpoint}-" . str_replace('display-', '', $value)
                };
            }
        } else {
            if (!str_contains($class, "fs-taggable")) {
                $class .= " fs-taggable";
            }
            $size_vars[] = match ($breakpoint) {
                'xs' => "--font-size: {$value};",
                default => "--font-size-{$breakpoint}: {$value};"
            };
        }
    }
}

foreach ($title['color'] as $breakpoint => $value) {
    if ($value) {
        $color[] = match ($breakpoint) {
            'xs' => "text-{$value}",
            default => "text-{$breakpoint}-{$value}"
        };
    }
}

foreach ($title['weight'] as $breakpoint => $value) {
    if ($value) {
        $weight[] = match ($breakpoint) {
            'xs' => "font-{$value}",
            default => "font-{$breakpoint}-{$value}"
        };
    }
}

$class = collect([])
    ->push($title['class'])
    ->push($class)
    ->merge($color)
    ->merge($weight)
    ->merge($size)
    ->filter()
    ->implode(' ');

$style = collect([])
    ->merge($size_vars)
    ->filter()
    ->implode(' ');

echo sprintf('<%s class="%s" style="%s">%s</%s>', $level, $class, $style, $text, $level);
@endphp