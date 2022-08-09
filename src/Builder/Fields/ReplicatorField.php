<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;

class ReplicatorField extends Field
{
    protected static function blueprint(): array
    {
        return [
            'config' => [],
        ];
    }

    public function __toString(): string
    {
        return collect($this->value())->first();
    }
}
