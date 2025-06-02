@php
  $classes = ["buildystrap-bg-element"];
  $inline_styles = [];

  if ($background['background_element_class'] ?? false) {
    $classes[] = $background['background_element_class'];
  }

  $wp_image_size = $background['image']['image-size'] ?? 'full';
  
  foreach ($background['image']['id'] ?? [] as $breakpoint => $value) {
    $imageUrl = collect($value)
      ->take(1)
      ->map(fn ($image) => wp_get_attachment_image_url($image['id'], $wp_image_size[$breakpoint]))
      ->first();

    if (!empty($imageUrl)) {
      $inline_styles[] = match ($breakpoint) {
        'xs' => "--bg-image-url: url('{$imageUrl}');",
        default => "--bg-image-url-{$breakpoint}: url('{$imageUrl}');"
      };
    }
  }

  /** Background Image Size */
  foreach ($background['image']['size'] ?? [] as $breakpoint => $value) {
    $classes[] = match ($breakpoint) {
      'xs' => "bg-{$value}",
      default => "bg-{$breakpoint}-{$value}"
    };
  }

  /** Background Image Position */
  foreach ($background['image']['position'] ?? [] as $breakpoint => $value) {
    $classes[] = match ($breakpoint) {
      'xs' => "bg-{$value}",
      default => "bg-{$breakpoint}-{$value}"
    };
  }

  /** Background Image Repeat */
  foreach ($background['image']['repeat'] ?? [] as $breakpoint => $value) {
    $classes[] = match ($breakpoint) {
      'xs' => "bg-{$value}",
      default => "bg-{$breakpoint}-{$value}"
    };
  }

  /** Background Color */
  foreach ($background['color'] ?? [] as $breakpoint => $value) {
    $classes[] = match ($breakpoint) {
      'xs' => "bg-{$value}",
      default => "bg-{$breakpoint}-{$value}"
    };
  }

  /** Background Blend Mode */
  foreach ($background['image']['blend-mode'] ?? [] as $breakpoint => $value) {
    $classes[] = match ($breakpoint) {
      'xs' => "bg-blend-{$value}",
      default => "bg-blend-{$breakpoint}-{$value}"
    };
  }
    
@endphp

<div class="{{ collect($classes)->implode(' ') }}" style="{{ collect($inline_styles)->implode(' ') }}"></div>