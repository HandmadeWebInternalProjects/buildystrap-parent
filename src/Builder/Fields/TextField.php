<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;
use Illuminate\Support\Collection;

class TextField extends Field
{
    protected function augment(): void
    {
    }

    public static function blueprint(): Collection
    {
        return collect([
            'input_type' => 'text'
        ]);
    }
}
