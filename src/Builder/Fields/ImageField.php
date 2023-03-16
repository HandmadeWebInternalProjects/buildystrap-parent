<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;
use function wp_get_attachment_image;

class ImageField extends Field
{
    protected static function blueprint(): array
    {
        return [
      'config' => [],
    ];
    }

    public function __toString(): string
    {
        $image = isset($this->value()['image']) ? $this->value()['image'] : null;
        if ( ! $image) {
            return false;
        }
        return collect($image)
      ->map(fn ($item) => wp_get_attachment_image_url($item['id'], 'full'))
      ->first();
    }

    public function toHtml(): string
    {
        $image = isset($this->value()['image']) ? $this->value()['image'] : null;
        if ( ! $image) {
            return false;
        }
        return collect($image)
      ->map(fn ($item) => wp_get_attachment_image($item['id'], 'full'))
      ->implode('');
    }
}
