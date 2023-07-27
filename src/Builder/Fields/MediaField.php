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

  private function getImage($item)
  {
    $attachment_details = wp_get_attachment_metadata($item['id']);

    if (!$attachment_details) {
      return "";
    }
    
    $filename = pathinfo($attachment_details['file'], PATHINFO_FILENAME);

    $this->additional_classes = $this->additional_classes . ' image-' . $filename;

    return wp_get_attachment_image($item['id'], $this->size, false, [
      'class' => $this->additional_classes,
      'alt' => $attachment_details['alt'] ?? '',
    ]);
  }

  public function withSize($size = null): string
  {
    return $this->size = $size ?? $this->config['size'] ?? 'full';
  }

  public function __toString(): string
  {
    return collect($this->value())
    ->map(function ($item) {
      return $this->getImage($item);
    })->first();
  }

  public function toHtml(): string
  {
    return collect($this->value())
      ->map(function ($item) {
        return $this->getImage($item);
      })
      ->implode('');
  }
}
