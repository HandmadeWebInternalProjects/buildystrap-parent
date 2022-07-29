<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class RelationalField extends Field
{
    protected static function blueprint(): array
    {
        return [
            'config' => [],
        ];
    }

    public function __toString(): string
    {
        return $this->value()->first()->post_title;
    }

    public function augment(): void
    {
        $value = $this->value;
        $this->value = collect($value)->map(function ($item) {
            return get_post($item);
        });
    }
}
