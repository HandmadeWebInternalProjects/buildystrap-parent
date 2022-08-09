<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;
use function get_post;

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
        $this->value = collect($this->value)->map(fn ($item) => get_post($item))->filter();
    }
}
