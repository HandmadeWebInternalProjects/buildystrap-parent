<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

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
        return '<em>error: you must loop through the fields on replicator modules</em>';
    }
}
