<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;
use function wp_get_attachment_image;

class MediaField extends Field
{
  public $size = 'full';

  protected static function blueprint(): array
  {
    return [
      'config' => [],
    ];
  }

  public function withSize($size = null): string
  {
    return $this->size = $size ?? $this->config['size'] ?? 'full';
  }

  public function __toString(): string
  {
    return collect($this->value())
      ->map(fn ($item) => wp_get_attachment_image_url($item['id'], $this->size))
      ->first();
  }

  public function toHtml(): string
  {
    return collect($this->value())
      ->map(fn ($item) => wp_get_attachment_image($item['id'], $this->size, false, ['class' => $this->additional_classes]))
      ->implode('');
  }
}
