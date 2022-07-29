<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class MediaField extends Field
{
    protected static function blueprint(): array
    {
        return [
            'config' => [],
        ];
    }

    public function __toString(): string
    {
        return collect($this->value())
          ->map(fn ($item) => wp_get_attachment_image($item->id, 'full'))
          ->implode('');
    }
}
